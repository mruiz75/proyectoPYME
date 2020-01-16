package com.example.pruebaapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    EditText editTextEmail, editTextContrasena;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editTextEmail = (EditText) findViewById(R.id.editTextEmail);
        editTextContrasena = (EditText) findViewById(R.id.editTextContrasena);

        findViewById(R.id.buttonLogin).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                userLogin();
            }
        });

        findViewById(R.id.textViewRegister).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //open register screen
                finish();
                startActivity(new Intent(getApplicationContext(), RegistroActivity.class));
            }
        });
    }

    private void userLogin() {
        // Se obtienen los valores insertados
        final String email = editTextEmail.getText().toString();
        final String contrasena = editTextContrasena.getText().toString();

        // Se valida que se ingresen los valores
        if (TextUtils.isEmpty(email)) {
            editTextEmail.setError("Por favor ingrese su email");
            editTextEmail.requestFocus();
            return;
        }

        if (TextUtils.isEmpty(contrasena)) {
            editTextContrasena.setError("Por favor ingrese su contraseña");
            editTextContrasena.requestFocus();
            return;
        }

        class UserLogin extends AsyncTask<Void, Void, String> {


            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);

                try {
                    //conversión a objeto JSON
                    JSONObject obj = new JSONObject(s);


                    if (!obj.getBoolean("error")) {
                        Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_SHORT).show();

                        //obteniendo email de la respuesta
                        JSONObject userJson = obj.getJSONObject("usuario");

                        //se crea nuevo objeto usuario
                        Usuario usuario = new Usuario(
                                userJson.getInt("cedula"),
                                userJson.getString("nombre"),
                                userJson.getString("apellido1"),
                                userJson.getString("apellido2"),
                                userJson.getString("email"),
                                userJson.getString("telefono"),
                                userJson.getString("departamento"),
                                userJson.getString("posicion")
                        );

                        //guardando el usuario en shared preferences
                        SharedPrefManager.getInstance(getApplicationContext()).userLogin(usuario);

                        //comenzando actividad de home
                        finish();
                        startActivity(new Intent(getApplicationContext(), InicioActivity.class));
                        //startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                    } else {
                        Toast.makeText(getApplicationContext(), "Email o contraseña inválidos", Toast.LENGTH_SHORT).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            protected String doInBackground(Void... voids) {
                //creating request handler object
                RequestHandler requestHandler = new RequestHandler();

                //creating request parameters
                HashMap<String, String> params = new HashMap<>();
                params.put("email", email);
                params.put("contrasena", contrasena);

                //returing the response
                return requestHandler.sendPostRequest(URLs.URL_LOGIN, params);
            }
        }

        UserLogin ul = new UserLogin();
        ul.execute();
    }

}
