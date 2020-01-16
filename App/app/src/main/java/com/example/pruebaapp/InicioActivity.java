package com.example.pruebaapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.JsonReader;
import android.view.View;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

public class InicioActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio);

        if(!SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            startActivity(new Intent(this, MainActivity.class));
        }

        findViewById(R.id.buttonHojaTiempo).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                getHojaDeTiempo();
            }
        });
//
//        findViewById(R.id.buttonBandejaEntrada).setOnClickListener(new View.OnClickListener(){
//            @Override
//            public void onClick(View view){
//                finish();
//                SharedPrefManager.getInstance(getApplicationContext()).;
//            }
//        });
//
//        findViewById(R.id.buttonGestionTareas).setOnClickListener(new View.OnClickListener(){
//            @Override
//            public void onClick(View view){
//                finish();
//                SharedPrefManager.getInstance(getApplicationContext()).;
//            }
//        });

        findViewById(R.id.buttonLogout).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                finish();
                SharedPrefManager.getInstance(getApplicationContext()).logout();
            }
        });
    }

    private void getHojaDeTiempo(){

        Usuario usuario = SharedPrefManager.getInstance(this).getUser();

        final String cedula = String.valueOf(usuario.getCedula());

        class UserHojaDeTiempo extends AsyncTask<Void, Void, String>{

            @Override
            protected void onPostExecute(String s){
                super.onPostExecute(s);

                try{
                    JSONObject obj = new JSONObject(s);

                    if(!obj.getBoolean("error")){
                        Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_SHORT).show();

                        //JSONObject tareasJson = obj.getJSONObject("tareas");
                        //JSONObject hojaJson = obj.getJSONObject("hoja");
                        JSONObject resultadoJson = obj.getJSONObject("resultado");

                        Intent intent = new Intent(getApplicationContext(), HojaTiempoActivity.class);
                        //intent.putExtra("tareasJson", tareasJson.toString());
                        //intent.putExtra("hojaJson", hojaJson.toString());
                        intent.putExtra("resultadoJson", resultadoJson.toString());

                        finish();
                        startActivity(intent);

                    }

                }catch(JSONException e){
                    e.printStackTrace();
                }


            }

            @Override
            protected String doInBackground(Void... voids){
                RequestHandler requestHandler = new RequestHandler();

                HashMap<String, String> params = new HashMap<>();
                params.put("cedula", cedula);

                return requestHandler.sendPostRequest(URLs.URL_HOJATIEMPO, params);
            }
        }

        UserHojaDeTiempo uht = new UserHojaDeTiempo();
        uht.execute();
    }


}
