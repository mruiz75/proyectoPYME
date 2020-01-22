package com.example.pruebaapp;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import androidx.appcompat.app.AppCompatActivity;
import android.text.TextUtils;
import android.view.View;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import android.os.Bundle;

public class RegistroActivity extends AppCompatActivity {

    EditText editTextCedula, editTextNombre, editTextApellido1, editTextApellido2, editTextEmail, editTextContrasena, editTextTelefono;
    RadioGroup radioGroupPosicion, radioGroupDepartamento;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro);

        if(SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            startActivity(new Intent(this, HomeActivity.class));
            return;
        }

        editTextCedula = (EditText) findViewById(R.id.editTextCedula);
        editTextNombre = (EditText) findViewById(R.id.editTextNombre);
        editTextApellido1 = (EditText) findViewById(R.id.editTextApellido1);
        editTextApellido2 = (EditText) findViewById(R.id.editTextApellido2);
        editTextEmail = (EditText) findViewById(R.id.editTextEmail);
        editTextContrasena = (EditText) findViewById(R.id.editTextContrasena);
        editTextTelefono = (EditText) findViewById(R.id.editTextTelefono);
        radioGroupPosicion = (RadioGroup) findViewById(R.id.radioPosicion);
        radioGroupDepartamento = (RadioGroup) findViewById(R.id.radioDepartamento);

        findViewById(R.id.textViewLogin).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                //if user pressed on login
                //we will open the login screen
                finish();
                startActivity(new Intent(RegistroActivity.this, MainActivity.class));
            }
        });

        findViewById(R.id.buttonRegister).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                registerUser();
            }
        });
    }


    private void registerUser() {
        final String cedula = editTextCedula.getText().toString().trim();
        final String nombre = editTextNombre.getText().toString().trim();
        final String apellido1 = editTextApellido1.getText().toString().trim();
        final String apellido2 = editTextApellido2.getText().toString().trim();
        final String email = editTextEmail.getText().toString().trim();
        final String contrasena = editTextContrasena.getText().toString().trim();
        final String telefono = editTextTelefono.getText().toString().trim();

        final String posicion = ((RadioButton) findViewById(radioGroupPosicion.getCheckedRadioButtonId())).getText().toString();
        final String departamento = ((RadioButton) findViewById(radioGroupDepartamento.getCheckedRadioButtonId())).getText().toString();

        //first we will do the validations

        if (TextUtils.isEmpty(cedula)) {
            editTextCedula.setError("Por favor ingrese la cédula");
            editTextCedula.requestFocus();
            return;
        }

        if (TextUtils.isEmpty(nombre)) {
            editTextNombre.setError("Por favor ingrese el Nombre");
            editTextNombre.requestFocus();
            return;
        }

        if (TextUtils.isEmpty(apellido1)) {
            editTextApellido1.setError("Por favor ingrese el Apellido 1");
            editTextApellido1.requestFocus();
            return;
        }

        if (TextUtils.isEmpty(apellido2)) {
            editTextApellido2.setError("Por favor ingrese el Apellido 2");
            editTextApellido2.requestFocus();
            return;
        }

        if (TextUtils.isEmpty(email)) {
            editTextEmail.setError("Por favor ingrese su email");
            editTextEmail.requestFocus();
            return;
        }

        if (!android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            editTextEmail.setError("Por favor ingrese un email válido");
            editTextEmail.requestFocus();
            return;
        }

        if (TextUtils.isEmpty(contrasena)) {
            editTextContrasena.setError("Ingrese una contraseña");
            editTextContrasena.requestFocus();
            return;
        }

        if(TextUtils.isEmpty(telefono)){
            editTextTelefono.setError("Por favor ingrese el teléfono");
            editTextTelefono.requestFocus();
            return;
        }


        //if it passes all the validations

        class RegisterUser extends AsyncTask<Void, Void, String> {


            @Override
            protected String doInBackground(Void... voids) {
                //creating request handler object
                RequestHandler requestHandler = new RequestHandler();

                //creating request parameters
                HashMap<String, String> params = new HashMap<>();
                params.put("cedula", cedula);
                params.put("nombre", nombre);
                params.put("apellido1", apellido1);
                params.put("apellido2", apellido2);
                params.put("email", email);
                params.put("contrasena", contrasena);
                params.put("telefono", telefono);
                params.put("posicion", posicion);
                params.put("departamento", departamento);

                //returing the response
                return requestHandler.sendPostRequest(URLs.URL_REGISTER, params);
            }


            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);

                try {
                    //converting response to json object
                    JSONObject obj = new JSONObject(s);

                    //if no error in response
                    if (!obj.getBoolean("error")) {
                        Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_SHORT).show();

                        //getting the user from the response
                        JSONObject userJson = obj.getJSONObject("usuario");

                        //creating a new user object
                        Usuario usuario = new Usuario(
                                userJson.getInt("cedula"),
                                userJson.getString("nombre"),
                                userJson.getString("apellido1"),
                                userJson.getString("apellido2"),
                                userJson.getString("email"),
                                userJson.getString("telefono"),
                                userJson.getString("posicion"),
                                userJson.getString("deparamento")
                        );

                        //storing the user in shared preferences
                        SharedPrefManager.getInstance(getApplicationContext()).userLogin(usuario);

                        //starting the profile activity
                        finish();
                        startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                    } else {
                        Toast.makeText(getApplicationContext(), "Some error occurred", Toast.LENGTH_SHORT).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }

        //executing the async task
        RegisterUser ru = new RegisterUser();
        ru.execute();
    }
}
