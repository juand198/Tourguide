package com.example.tourguide.ui;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.preference.PreferenceManager;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.Switch;
import android.widget.Toast;

import com.example.tourguide.MainActivity;
import com.example.tourguide.R;
import com.example.tourguide.controladores.ControladorBaseDatos;
import com.example.tourguide.controladores.ServidorPHPException;
import com.example.tourguide.modelo.Guia;
import com.example.tourguide.modelo.Turista;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;

import es.dmoral.toasty.Toasty;

public class Login extends AppCompatActivity implements CompoundButton.OnCheckedChangeListener {

    private Button iniciarSesion, registrarseLogin, pswdOlvidada;
    private EditText etEmail,etPswd;
    private Switch swGuia;
    private FirebaseAuth mAuth;
    private SharedPreferences prefs;
    private SharedPreferences.Editor editor;
    private Boolean guia = false;
    private ControladorBaseDatos controlador;
    private  Context contexto;


    public void iniciarSesion(String email,String password){
        mAuth.signInWithEmailAndPassword(email, password)
                .addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            // Sign in success, update UI with the signed-in user's information
                            FirebaseUser user = mAuth.getCurrentUser();
                            try {
                                if(controlador.obtenerGuia(user.getUid())!= null){
                                    updateUI(user);
                                }else{
                                    Toasty.error(getBaseContext(), "Usuario y contraseña correctos, nuestros servidores estan sufriendo un mantenimiento vuelva a intentarlo de nuevo", Toast.LENGTH_SHORT, true).show();
                                }
                                if(controlador.obtenerTurista(user.getUid())!= null){
                                    updateUI(user);
                                }else{
                                    Toasty.error(getBaseContext(), "Usuario y contraseña correctos, nuestros servidores estan sufriendo un mantenimiento vuelva a intentarlo de nuevo", Toast.LENGTH_SHORT, true).show();
                                }
                            } catch (ServidorPHPException e) {
                                e.printStackTrace();
                            }

                        } else {
                            // If sign in fails, display a message to the user.
                            updateUI(null);
                        }
                    }
                });
    }

    public void obtenerDatosPerfil(){
        FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();
        if (user != null) {
            // Name, email address, and profile photo Url
            String name = user.getDisplayName();
            String email = user.getEmail();
            Uri photoUrl = user.getPhotoUrl();

            // Check if user's email is verified
            boolean emailVerified = user.isEmailVerified();

            // The user's ID, unique to the Firebase project. Do NOT use this value to
            // authenticate with your backend server, if you have one. Use
            // FirebaseUser.getIdToken() instead.
            String uid = user.getUid();

            if(guia) {
                try {
                    Guia g = controlador.obtenerGuia(user.getUid());
                    Turista t = controlador.obtenerTurista(user.getUid());
                    if (g!=null){
                        editor.putString("nombre", g.getNombre());
                        editor.putString("email", g.getEmail());
                        editor.putString("ciudad", g.getCiudad());
                        editor.putString("apellidos", g.getApellido());
                        editor.putString("token",g.getToken());
                        editor.putString("provincia",g.getProvincia());
                        editor.putString("modo", "guia");
                        editor.commit();
                        Intent intent = new Intent(this, MainActivity.class);
                        startActivity(intent);
                        finish();
                    }else{
                        editor.putString("nombre", t.getNombre());
                        editor.putString("email", t.getEmail());
                        editor.putString("token",t.getToken());
                        editor.putString("apellidos", t.getApellidos());
                        editor.putString("ciudad", g.getCiudad());
                        editor.putString("provincia",g.getProvincia());
                        editor.putString("modo", "turista");
                        editor.commit();
                        Intent intent = new Intent(this, MainActivity.class);
                        startActivity(intent);
                        finish();
                    }
                } catch (ServidorPHPException e) {
                    e.printStackTrace();
                }
            }else{
                try {
                    Turista t = controlador.obtenerTurista(user.getUid());
                    Guia g = controlador.obtenerGuia(user.getUid());
                    if (t!=null){
                        editor.putString("nombre", t.getNombre());
                        editor.putString("email", t.getEmail());
                        editor.putString("token",t.getToken());
                        editor.putString("apellidos", t.getApellidos());
                        editor.putString("provincia",g.getProvincia());
                        editor.putString("ciudad", g.getCiudad());
                        editor.putString("modo", "turista");
                        editor.commit();
                        Intent intent = new Intent(this, MainActivity.class);
                        startActivity(intent);
                        finish();
                    }else{

                        editor.putString("nombre", g.getNombre());
                        editor.putString("email", g.getEmail());
                        editor.putString("token",g.getToken());
                        editor.putString("ciudad", g.getCiudad());
                        editor.putString("apellidos", g.getApellido());
                        editor.putString("provincia",g.getProvincia());
                        editor.putString("modo", "guia");
                        editor.commit();
                        Intent intent = new Intent(this, MainActivity.class);
                        startActivity(intent);
                        finish();
                    }
                } catch (ServidorPHPException e) {
                    e.printStackTrace();
                }
            }

        }
    }

    public void updateUI(FirebaseUser user){
        if (user != null){
            obtenerDatosPerfil();
        }
        else if (user == null){
            //Si has agregado mal
            Toasty.error(this, "Usuario o contraseña incorrectos", Toast.LENGTH_SHORT, true).show();
        }
    }



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        contexto = getApplicationContext();

        etEmail = findViewById(R.id.tfEmail);
        etPswd = findViewById(R.id.tfPswd);
        prefs = PreferenceManager.getDefaultSharedPreferences(this);
        editor = prefs.edit();
        iniciarSesion = findViewById(R.id.bIniciarSesion);
        registrarseLogin = findViewById(R.id.bRegistrarseLogin);
        pswdOlvidada = findViewById(R.id.bPswdOlvidado);
        mAuth = FirebaseAuth.getInstance();
        swGuia = findViewById(R.id.swEresGuia);
        swGuia.setOnCheckedChangeListener(this);
        controlador = new ControladorBaseDatos();

        try {
            if(prefs.getString("modo","").equals("turista")){
                if (controlador.obtenerTurista(controlador.obtenerTurista(prefs.getString("token","")).getToken())!=null){
                    Intent intent = new Intent(this, MainActivity.class);
                    startActivity(intent);
                    finish();
                }
            } else if (prefs.getString("modo","").equals("guia")){
                if (controlador.obtenerTurista(controlador.obtenerGuia(prefs.getString("token","")).getToken())!=null){
                    Intent intent = new Intent(this, MainActivity.class);
                    startActivity(intent);
                    finish();
                }
            }
        } catch (ServidorPHPException e) {
            e.printStackTrace();
        }

        iniciarSesion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!etEmail.getText().toString().isEmpty() && !etPswd.getText().toString().isEmpty()){
                    iniciarSesion(etEmail.getText().toString(),etPswd.getText().toString());
                }else{
                    Toasty.error(contexto,"Los campos no pueden estar vacios",Toast.LENGTH_LONG).show();
                }

            }
        });
        registrarseLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Intent intent = new Intent(getBaseContext(), Registrarse.class);
                startActivity(intent);

            }
        });

    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
        switch (buttonView.getId()){
            case R.id.swEresGuia:
                guia = isChecked;
                break;
        }
    }

    /**
     * Comprueba que ya haya iniciado sesion
     */
    @Override
    public void onStart() {
        super.onStart();
        // Check if user is signed in (non-null) and update UI accordingly.
        FirebaseUser currentUser = mAuth.getCurrentUser();
        //updateUI(currentUser);
    }
}
