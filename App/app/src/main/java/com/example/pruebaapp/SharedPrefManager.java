package com.example.pruebaapp;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

public class SharedPrefManager {

    private static final String SHARED_PREF_NAME = "sharedpref";
    private static final String KEY_CEDULA = "keycedula";
    private static final String KEY_NOMBRE = "keynombre";
    private static final String KEY_APELLIDO1 = "keyapellido1";
    private static final String KEY_APELLIDO2 = "keyapellido2";
    private static final String KEY_EMAIL = "keyemail";
    private static final String KEY_TELEFONO = "keytelefono";
    private static final String KEY_POSICION = "keyposicion";
    private static final String KEY_DEPARTAMENTO = "keydepartamento";

    private static SharedPrefManager mInstance;
    private static Context mCtx;

    private SharedPrefManager(Context context){
        mCtx = context;
    }

    public static synchronized SharedPrefManager getInstance(Context context) {
        if (mInstance == null) {
            mInstance = new SharedPrefManager(context);
        }
        return mInstance;
    }

    public void userLogin(Usuario usuario) {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt(KEY_CEDULA, usuario.getCedula());
        editor.putString(KEY_NOMBRE, usuario.getNombre());
        editor.putString(KEY_APELLIDO1, usuario.getApellido1());
        editor.putString(KEY_APELLIDO2, usuario.getApellido2());
        editor.putString(KEY_EMAIL, usuario.getEmail());
        editor.putString(KEY_TELEFONO, usuario.getTelefono());
        editor.putString(KEY_POSICION, usuario.getPosicion());
        editor.putString(KEY_DEPARTAMENTO, usuario.getDepartamento());
        editor.apply();
    }

    public boolean isLoggedIn() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getString(KEY_NOMBRE, null) != null;
    }

    public Usuario getUser() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        return new Usuario(
                sharedPreferences.getInt(KEY_CEDULA, -1),
                sharedPreferences.getString(KEY_NOMBRE, null),
                sharedPreferences.getString(KEY_APELLIDO1, null),
                sharedPreferences.getString(KEY_APELLIDO2, null),
                sharedPreferences.getString(KEY_EMAIL, null),
                sharedPreferences.getString(KEY_TELEFONO, null),
                sharedPreferences.getString(KEY_POSICION, null),
                sharedPreferences.getString(KEY_DEPARTAMENTO, null)
        );
    }

    //this method will logout the user
    public void logout() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.clear();
        editor.apply();
        mCtx.startActivity(new Intent(mCtx, MainActivity.class));
    }

}
