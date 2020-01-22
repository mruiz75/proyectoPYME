package com.example.pruebaapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

//Clase encargada de mostrar la información del reporte semanal del departamento.
public class ReporteActivity extends AppCompatActivity {

    TextView textViewFechaCreacion, textViewTareasRealizadas, textViewTareasNoRealizadas, textViewTiempoEfectivo, textViewTiempoEfectivoPromedio, textViewTiempoLibre, textViewTiempoLibrePromedio, textViewUsuarioMaxTareas, textViewMaxTareas, textViewUsuarioMinTareas, textViewMinTareas;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reporte);

        textViewFechaCreacion = (TextView) findViewById(R.id.textViewFechaCreacion);
        textViewTareasRealizadas= (TextView) findViewById(R.id.textViewTareasRealizadas);
        textViewTareasNoRealizadas = (TextView) findViewById(R.id.textViewTareasNoRealizadas);
        textViewTiempoEfectivo = (TextView) findViewById(R.id.textViewTiempoEfectivo);
        textViewTiempoEfectivoPromedio = (TextView) findViewById(R.id.textViewTiempoEfectivoPromedio);
        textViewTiempoLibre = (TextView) findViewById(R.id.textViewTiempoLibre);
        textViewTiempoLibrePromedio = (TextView) findViewById(R.id.textViewTiempoLibrePromedio);
        textViewUsuarioMaxTareas = (TextView) findViewById(R.id.textViewUsuarioMaxTareas);
        textViewMaxTareas = (TextView) findViewById(R.id.textViewMaxTareas);
        textViewUsuarioMinTareas = (TextView) findViewById(R.id.textViewUsuarioMinTareas);
        textViewMinTareas = (TextView) findViewById(R.id.textViewMinTareas);

        Reporte reporte = SharedPrefManager.getInstance(this).getReporte();

        textViewFechaCreacion.setText(String.valueOf(reporte.getFechaCreacion()));
        textViewTareasRealizadas.setText(String.valueOf(reporte.getTareasRealizadas()));
        textViewTareasNoRealizadas.setText(String.valueOf(reporte.getTareasNoRealizadas()));
        textViewTiempoEfectivo.setText(String.valueOf(reporte.getTiempoTareas()));
        textViewTiempoEfectivoPromedio.setText(String.valueOf(reporte.getTiempoPromedioTareas()));
        textViewTiempoLibre.setText(String.valueOf(reporte.getTiempolibre()));
        textViewTiempoLibrePromedio.setText(String.valueOf(reporte.getTiempoPromedioLibre()));
        textViewUsuarioMaxTareas.setText(String.valueOf(reporte.getUsuarioMaxTareas()));
        textViewMaxTareas.setText(String.valueOf(reporte.getMaxTareas()));
        textViewUsuarioMinTareas.setText(String.valueOf(reporte.getUsuarioMinTareas()));
        textViewMinTareas.setText(String.valueOf(reporte.getMinTareas()));

        findViewById(R.id.buttonVolverInicio).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                finish();
                startActivity(new Intent(getApplicationContext(), InicioActivity.class));
            }
        });
    }
}
