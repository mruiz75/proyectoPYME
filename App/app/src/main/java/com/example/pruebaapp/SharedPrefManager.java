package com.example.pruebaapp;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

/*
Clase utilizada para setear información de sesión, en este caso el usuario y el reporte semanal
correspondiente al departamento de ese usuario.
*/
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
    private static final String KEY_TAREASREALIZDAS = "keytareasrealizadas";
    private static final String KEY_TAREASNOREALIZADAS = "keytareasnorealizadas";
    private static final String KEY_MAXTAREAS = "keymaxtareas";
    private static final String KEY_MINTAREAS = "keymintareas";
    private static final String KEY_FECHACREACION = "keyfechacreacion";
    private static final String KEY_TIEMPOTAREAS = "keytiempotareas";
    private static final String KEY_TIEMPOPROMEDIOTAREAS = "keytiempopromediotareas";
    private static final String KEY_TIEMPOLIBRE = "keytiempolibre";
    private static final String KEY_TIEMPOPROMEDIOLIBRE = "keytiempopromediolibre";
    private static final String KEY_USUARIOMAXTAREAS = "keyusuariosmaxtareas";
    private static final String KEY_USUARIOMINTAREAS = "keyusuariosmintareas";

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

    /*
    Metodo utilizado para verificar que haya un usuario en sesión
     */
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

    public void reporteSemanal(Reporte reporte){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt(KEY_TAREASREALIZDAS, reporte.getTareasRealizadas());
        editor.putInt(KEY_TAREASNOREALIZADAS, reporte.getTareasNoRealizadas());
        editor.putInt(KEY_MAXTAREAS, reporte.getMaxTareas());
        editor.putInt(KEY_MINTAREAS, reporte.getMinTareas());
        editor.putString(KEY_FECHACREACION, reporte.getFechaCreacion());
        editor.putString(KEY_TIEMPOTAREAS, reporte.getTiempoTareas());
        editor.putString(KEY_TIEMPOPROMEDIOTAREAS, reporte.getTiempoPromedioTareas());
        editor.putString(KEY_TIEMPOLIBRE, reporte.getTiempolibre());
        editor.putString(KEY_TIEMPOPROMEDIOLIBRE, reporte.getTiempoPromedioLibre());
        editor.putString(KEY_USUARIOMAXTAREAS, reporte.getUsuarioMaxTareas());
        editor.putString(KEY_USUARIOMINTAREAS, reporte.getUsuarioMinTareas());
        editor.apply();
    }

    public Reporte getReporte(){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        return new Reporte(
                sharedPreferences.getInt(KEY_TAREASREALIZDAS, -1),
                sharedPreferences.getInt(KEY_TAREASNOREALIZADAS, -1),
                sharedPreferences.getInt(KEY_MAXTAREAS, -1),
                sharedPreferences.getInt(KEY_MINTAREAS, -1),
                sharedPreferences.getString(KEY_FECHACREACION, null),
                sharedPreferences.getString(KEY_TIEMPOTAREAS, null),
                sharedPreferences.getString(KEY_TIEMPOPROMEDIOTAREAS, null),
                sharedPreferences.getString(KEY_TIEMPOLIBRE, null),
                sharedPreferences.getString(KEY_TIEMPOPROMEDIOLIBRE, null),
                sharedPreferences.getString(KEY_USUARIOMAXTAREAS, null),
                sharedPreferences.getString(KEY_USUARIOMINTAREAS, null)
        );
    }

    //hace el logout del usuario
    public void logout() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.clear();
        editor.apply();
        mCtx.startActivity(new Intent(mCtx, MainActivity.class));
    }

}
