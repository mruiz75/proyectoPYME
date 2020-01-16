package com.example.pruebaapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class HomeActivity extends AppCompatActivity {


    TextView textViewCedula, textViewNombre, textViewEmail, textViewDepartamento;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        if(!SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            startActivity(new Intent(this, MainActivity.class));
        }

        textViewCedula = (TextView) findViewById(R.id.textViewCedula);
        textViewNombre = (TextView) findViewById(R.id.textViewNombre);
        textViewEmail = (TextView) findViewById(R.id.textViewEmail);
        textViewDepartamento = (TextView) findViewById(R.id.textViewDepartamento);

        Usuario usuario = SharedPrefManager.getInstance(this).getUser();

        textViewCedula.setText(String.valueOf(usuario.getCedula()));
        textViewNombre.setText(usuario.getNombre());
        textViewEmail.setText(usuario.getEmail());
        textViewDepartamento.setText(usuario.getDepartamento());

        findViewById(R.id.buttonLogout).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
                SharedPrefManager.getInstance(getApplicationContext()).logout();
            }
        });

    }


}
