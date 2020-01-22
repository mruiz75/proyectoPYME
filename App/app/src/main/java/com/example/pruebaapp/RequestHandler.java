package com.example.pruebaapp;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Map;

//Clase encargada de manejar los requests hechos por las actividades.
public class RequestHandler {

    /*
    Metodo encargado de manejar los request de tipo POST. Retorna un string con la información
    obtenida del servidor.
    @param: requestURL -> String con el URL hacia la API almacenada en el servidor
    @param: postDataParms -> hashmap con los datos necesario para hacer el POST
     */
    public String sendPostRequest(String requestURL, HashMap<String, String> postDataParms){
        URL url;

        StringBuilder sb = new StringBuilder();
        try{
            url = new URL(requestURL);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setReadTimeout(15000);
            conn.setConnectTimeout(15000);
            conn.setRequestMethod("POST");
            conn.setDoInput(true);
            conn.setDoOutput(true);

            OutputStream os = conn.getOutputStream();

            BufferedWriter writer = new BufferedWriter(
                    new OutputStreamWriter(os, "UTF-8"));
            writer.write(getPostDataString(postDataParms));

            writer.flush();
            writer.close();
            os.close();
            int responseCode = conn.getResponseCode();

            if(responseCode == HttpURLConnection.HTTP_OK) {
                BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                sb = new StringBuilder();
                String response;

                while ((response = br.readLine()) != null) {
                    sb.append(response);
                }
            }

        }catch(Exception e){
            e.printStackTrace();
        }

        return sb.toString();

    }

    /*
    Metodo que se encarga de obtener información del servidor. Retorna un string con la información devuelta por el API.
    @param: requestURL -> String con el URL hacia la API almacenada en el servidor
     */
    public String sendGetRequest(String requestURL) {
        URL url;

        StringBuilder sb = new StringBuilder();
        try {
            url = new URL(requestURL);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(conn.getInputStream()));

            String s;
            while ((s = bufferedReader.readLine()) != null) {
                sb.append(s + "\n");
            }
        } catch (Exception e) {
        }
        return sb.toString();
    }

    /*
    Método encargado de generar el string con los parametros ingresados por el usuario que va a ser enviado a través del POST
    @param: params -> hashmap con los string de los datos que ingreso el usuario.
     */
    private String getPostDataString(HashMap<String, String> params) throws UnsupportedEncodingException {
        StringBuilder result = new StringBuilder();
        boolean first = true;
        for (Map.Entry<String, String> entry : params.entrySet()) {
            if (first)
                first = false;
            else
                result.append("&");

            result.append(URLEncoder.encode(entry.getKey(), "UTF-8"));
            result.append("=");
            result.append(URLEncoder.encode(entry.getValue(), "UTF-8"));
        }

        return result.toString();
    }
}
