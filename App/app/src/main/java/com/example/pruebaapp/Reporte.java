package com.example.pruebaapp;

// Clase de objeto Reporte
public class Reporte {

    private int tareasRealizadas, tareasNoRealizadas, maxTareas, minTareas;
    private String fechaCreacion, tiempoTareas, tiempoPromedioTareas, tiempolibre, tiempoPromedioLibre, usuarioMaxTareas, usuarioMinTareas;

    public Reporte(int tareasRealizadas, int tareasNoRealizadas, int maxTareas, int minTareas, String fechaCreacion, String tiempoTareas, String tiempoPromedioTareas, String tiempolibre, String tiempoPromedioLibre, String usuarioMaxTareas, String usuarioMinTareas) {
        this.tareasRealizadas = tareasRealizadas;
        this.tareasNoRealizadas = tareasNoRealizadas;
        this.maxTareas = maxTareas;
        this.minTareas = minTareas;
        this.fechaCreacion = fechaCreacion;
        this.tiempoTareas = tiempoTareas;
        this.tiempoPromedioTareas = tiempoPromedioTareas;
        this.tiempolibre = tiempolibre;
        this.tiempoPromedioLibre = tiempoPromedioLibre;
        this.usuarioMaxTareas = usuarioMaxTareas;
        this.usuarioMinTareas = usuarioMinTareas;
    }

    public int getTareasRealizadas() {
        return tareasRealizadas;
    }

    public void setTareasRealizadas(int tareasRealizadas) {
        this.tareasRealizadas = tareasRealizadas;
    }

    public int getTareasNoRealizadas() {
        return tareasNoRealizadas;
    }

    public void setTareasNoRealizadas(int tareasNoRealizadas) {
        this.tareasNoRealizadas = tareasNoRealizadas;
    }

    public int getMaxTareas() {
        return maxTareas;
    }

    public void setMaxTareas(int maxTareas) {
        this.maxTareas = maxTareas;
    }

    public int getMinTareas() {
        return minTareas;
    }

    public void setMinTareas(int minTareas) {
        this.minTareas = minTareas;
    }

    public String getFechaCreacion() {
        return fechaCreacion;
    }

    public void setFechaCreacion(String fechaCreacion) {
        this.fechaCreacion = fechaCreacion;
    }

    public String getTiempoTareas() {
        return tiempoTareas;
    }

    public void setTiempoTareas(String tiempoTareas) {
        this.tiempoTareas = tiempoTareas;
    }

    public String getTiempoPromedioTareas() {
        return tiempoPromedioTareas;
    }

    public void setTiempoPromedioTareas(String tiempoPromedioTareas) {
        this.tiempoPromedioTareas = tiempoPromedioTareas;
    }

    public String getTiempolibre() {
        return tiempolibre;
    }

    public void setTiempolibre(String tiempolibre) {
        this.tiempolibre = tiempolibre;
    }

    public String getTiempoPromedioLibre() {
        return tiempoPromedioLibre;
    }

    public void setTiempoPromedioLibre(String tiempoPromedioLibre) {
        this.tiempoPromedioLibre = tiempoPromedioLibre;
    }

    public String getUsuarioMaxTareas() {
        return usuarioMaxTareas;
    }

    public void setUsuarioMaxTareas(String usuarioMaxTareas) {
        this.usuarioMaxTareas = usuarioMaxTareas;
    }

    public String getUsuarioMinTareas() {
        return usuarioMinTareas;
    }

    public void setUsuarioMinTareas(String usuarioMinTareas) {
        this.usuarioMinTareas = usuarioMinTareas;
    }
}

