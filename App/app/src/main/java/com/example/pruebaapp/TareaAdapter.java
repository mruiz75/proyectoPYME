package com.example.pruebaapp;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.List;

public class TareaAdapter extends ArrayAdapter {

    List list = new ArrayList();

    public TareaAdapter(Context context, int resource){
        super(context, resource);
    }

    public void add(Tarea object) {
        super.add(object);
        list.add(object);
    }

    @Override
    public int getCount() {
        return list.size();
    }

    @Nullable
    @Override
    public Object getItem(int position) {
        return list.get(position);
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        View row;
        row = convertView;
        TareaHolder tareaHolder = null;
        if(row == null){
            LayoutInflater layoutInflater = (LayoutInflater) this.getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            row = layoutInflater.inflate(R.layout.row_layout, parent, false);
            tareaHolder.tx_id = (TextView) row.findViewById(R.id.tx_id);
            tareaHolder.tx_tarea = (TextView) row.findViewById(R.id.tx_tarea);
            tareaHolder.tx_lunes = (TextView) row.findViewById(R.id.tx_lunes);
            tareaHolder.tx_martes = (TextView) row.findViewById(R.id.tx_martes);
            tareaHolder.tx_miercoles = (TextView) row.findViewById(R.id.tx_miercoles);
            tareaHolder.tx_jueves = (TextView) row.findViewById(R.id.tx_jueves);
            tareaHolder.tx_viernes = (TextView) row.findViewById(R.id.tx_viernes);
            row.setTag(tareaHolder);
        }else{
            tareaHolder = (TareaHolder)row.getTag();
        }

        Tarea tarea = (Tarea) this.getItem(position);
        tareaHolder.tx_id.setText(tarea.getId());
        //String nombreYDesc = tarea.getNombre() + "\n" + tarea.getDescripcion();
        tareaHolder.tx_tarea.setText(tarea.getNombre() + '\n' + tarea.getDescripcion());
        tareaHolder.tx_lunes.setText(tarea.getLunes());
        tareaHolder.tx_martes.setText(tarea.getMartes());
        tareaHolder.tx_miercoles.setText(tarea.getMiercoles());
        tareaHolder.tx_jueves.setText(tarea.getJueves());
        tareaHolder.tx_viernes.setText(tarea.getViernes());
        return super.getView(position, convertView, parent);
    }

    static class TareaHolder{
        TextView tx_tarea, tx_id, tx_lunes, tx_martes, tx_miercoles, tx_jueves, tx_viernes;
    }
}
