package com.example.pruebaapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

//Clase imcompleta. Su implementación requiere de algunos cambios y modificación del código
public class HojaTiempoActivity extends AppCompatActivity {

    TareaAdapter tareaAdapter;
    ListView listView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_hoja_tiempo);

        listView = (ListView)findViewById(R.id.listview);
        tareaAdapter = new TareaAdapter(this, R.layout.row_layout);
        listView.setAdapter(tareaAdapter);

        Intent intent = getIntent();
        //String tareasString = intent.getStringExtra("tareasJson");
        //String hojasString = intent.getStringExtra("hojaJson");
        String resultadoString = intent.getStringExtra("resultadoJson");


        //JSONObject tareasJson, hojaJson;
        JSONObject resultadoJson, hojaJson;
        JSONArray tareasArray;

        try {
            resultadoJson = new JSONObject(resultadoString);
            tareasArray = resultadoJson.getJSONArray("tareas");
            hojaJson = resultadoJson.getJSONObject("hoja");

            int count = 0;
            int id;
            String nombre, descripcion, lunes, martes, miercoles, jueves, viernes;

            while(count < tareasArray.length()){
                JSONObject JO = tareasArray.getJSONObject(count);
                id = JO.getInt("id");
                nombre = JO.getString("nombre");
                descripcion = JO.getString("descripcion");
                lunes = JO.getString("lunes");
                martes = JO.getString("martes");
                miercoles = JO.getString("miercoles");
                jueves = JO.getString("jueves");
                viernes = JO.getString("viernes");

                Tarea tarea = new Tarea(id, nombre, descripcion, lunes, martes, miercoles, jueves, viernes);
                tareaAdapter.add(tarea);
                count++;
            }

            //conversión a objeto JSON
            //JSONObject obj = new JSONObject(s);



        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
