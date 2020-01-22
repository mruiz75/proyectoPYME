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


//Clase casi completa, utilizada para realizar un registro de un nuevo usuario desde la aplicación móvil
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
            //caso el que el usuario desea volver al login
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


        //Si pasa todas las validaciones

        class RegisterUser extends AsyncTask<Void, Void, String> {

            /*El siguiente método se encarga de generar un mapa hash con los datos del usuario por registrar
              y los envia a través de un POST al api en el servidor para ser agregados como un nuevo usuario
              a la base de datos
             */
            @Override
            protected String doInBackground(Void... voids) {

                RequestHandler requestHandler = new RequestHandler();


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

                return requestHandler.sendPostRequest(URLs.URL_REGISTER, params);
            }

            /*
            Una vez creado un nuevo usuario, lo establece como el usuario en sesión y hace un llamado a la actividad Home
            o bien la actividad de inicio del app.
             */
            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);

                try {
                    JSONObject obj = new JSONObject(s);

                    if (!obj.getBoolean("error")) {
                        Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_SHORT).show();

                        JSONObject userJson = obj.getJSONObject("usuario");

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

                        //guarda el usuario en sharedPreferences
                        SharedPrefManager.getInstance(getApplicationContext()).userLogin(usuario);

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

        //ejecutando la clase Async
        RegisterUser ru = new RegisterUser();
        ru.execute();
    }
}
