package com.example.pruebaapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.JsonReader;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

//Clase con la actividad para el menú principal
public class InicioActivity extends AppCompatActivity {

    // Al crearse, se muestra un botón para leer el reporte semanal y otro para hacer Log Out
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio);

        if(!SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            startActivity(new Intent(this, MainActivity.class));
        }

        findViewById(R.id.buttonReporte).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                reporteSemanal();
            }
        });

        findViewById(R.id.buttonLogout).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                finish();
                SharedPrefManager.getInstance(getApplicationContext()).logout();
            }
        });
    }

    /*
    Metodo encargado de obtener la información del reporte semanal de la empresa, almacenar la información
    del reporte para toda la sesión y llamar a la actividad que muestra la inforamción del reporte.
     */
    private void reporteSemanal(){

        final Usuario usuario = SharedPrefManager.getInstance(this).getUser();

        final String departamento = String.valueOf(usuario.getDepartamento());

        class ReporteSemanal extends AsyncTask<Void, Void, String>{

            ProgressBar progressBar;

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                progressBar = (ProgressBar) findViewById(R.id.progressBar);
                progressBar.setVisibility(View.VISIBLE);
            }

            @Override
            protected void onPostExecute(String s){
                super.onPostExecute(s);
                progressBar.setVisibility(View.GONE);

                try{
                    JSONObject obj = new JSONObject(s);

                    if(!obj.getBoolean("error")){
                        Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_SHORT).show();

                        JSONObject reporteJson = obj.getJSONObject("reporte");

                        Reporte reporte = new Reporte(
                                reporteJson.getInt("tareasRealizadas"),
                                reporteJson.getInt("tareasNoRealizadas"),
                                reporteJson.getInt("maxTareas"),
                                reporteJson.getInt("minTareas"),
                                reporteJson.getString("fechaCreacion"),
                                reporteJson.getString("tiempoTareas"),
                                reporteJson.getString("tiempoPromedioTareas"),
                                reporteJson.getString("tiempoLibre"),
                                reporteJson.getString("tiempoPromedioLibre"),
                                reporteJson.getString("usuarioMaxTareas"),
                                reporteJson.getString("usuarioMinTareas")
                        );

                        SharedPrefManager.getInstance(getApplicationContext()).reporteSemanal(reporte);

                        finish();
                        startActivity(new Intent(getApplicationContext(), ReporteActivity.class));

                    }else{
                        Toast.makeText(getApplicationContext(), "No se ha encontrado ningun reporte", Toast.LENGTH_SHORT).show();
                    }

                }catch(JSONException e){
                    Toast.makeText(InicioActivity.this, e.getMessage(), Toast.LENGTH_LONG).show();
                    e.printStackTrace();
                }
            }

            @Override
            protected String doInBackground(Void... voids){
                RequestHandler requestHandler = new RequestHandler();

                HashMap<String, String> params = new HashMap<>();
                params.put("departamento", departamento);

                return requestHandler.sendPostRequest(URLs.URL_REPORTE, params);
            }

        }

        ReporteSemanal rs = new ReporteSemanal();
        rs.execute();
    }

    // Método incompleto que puede ser usado y adherido a un botón para llamar la hoja de tiempo.
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


                        JSONObject resultadoJson = obj.getJSONObject("resultado");

                        Intent intent = new Intent(getApplicationContext(), HojaTiempoActivity.class);

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
