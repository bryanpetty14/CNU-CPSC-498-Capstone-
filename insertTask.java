package com.example.bryan.myapplication;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.RequestFuture;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;


/**
 * Created by Bryan on 3/21/2018.
 */

public class insertTask extends AsyncTask<String, Void, String> {
    private final String ENTRY = "entry";
    private final String BUDGET = "budget";
    private final String USER = "user";
    private AppCompatActivity main;
    private RequestQueue queue;
    private String fromWeb;
    private final String ServerURL = "http://default-environment.rfemrggswx.us-west-2.elasticbeanstalk.com/";
    private ProgressDialog myProgressDialog;

    insertTask(MainActivity activity) {
        attach(activity);
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
        progressDialog_start();
    }


    private void progressDialog_start() {
        myProgressDialog = new ProgressDialog(main);
        /*myProgressDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "Cancel",
                new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        //dialog.dismiss();
                        //this.cancel(true);

                        //myProgressDialog = null;
                    }
                });*/
        myProgressDialog.setTitle("Please wait");
        myProgressDialog.setMessage("Attempting to insert data...");
        myProgressDialog.setCancelable(false);
        myProgressDialog.show();
    }

    private void progressDialog_stop(){
        if(myProgressDialog != null) {
            myProgressDialog.dismiss();
        }
    }

    private void storeResponse(String response){
        progressDialog_stop();
        Log.d("MAIN TASK", response);
        fromWeb = response;
        Toast.makeText(main, fromWeb, Toast.LENGTH_SHORT).show();
        Log.d("MAIN TASK", fromWeb);
    }
    void detach() {
        main = null;
    }

    void attach(MainActivity activity) {
        main = activity;
    }

    @Override
    protected void onPostExecute(String s) {
        super.onPostExecute(s);
        //Toast.makeText(main, fromWeb+s, Toast.LENGTH_SHORT).show();
        //detach();
    }

    @Override
    protected void onCancelled() {
        super.onCancelled();
    }

    @Override
    protected String doInBackground(String... strings) {
        fromWeb = "";
        String key;
        try {
            key = strings[0];
        } catch (Exception e) {
            return "no key given";
        }
        if (key.equals(ENTRY)) {
            final String NameHolder;
            final String CatHolder;
            final String YearHolder;
            final String MonthHolder;
            final String DayHolder;
            final String DescriptionHolder;
            final String AmountHolder;
            final String PlaceHolder;
            try {
                NameHolder = strings[1];
                CatHolder = strings[2];
                YearHolder = strings[3];
                MonthHolder = strings[4];
                DayHolder = strings[5];
                DescriptionHolder = strings[6];
                AmountHolder = strings[7];
                PlaceHolder = strings[8];
            } catch (Exception e) {
                return "Not Enough Information Given";
            }

            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "insertEntry.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response+" Into Entry");
                            Log.d("Response", response);
                            detach();
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // error
                            storeResponse(error.toString()+" For Entry");
                            Log.d("Error.Response", error.toString());
                        }
                    }
            ) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", NameHolder);
                    params.put("category", CatHolder);
                    params.put("year", YearHolder);
                    params.put("month", MonthHolder);
                    params.put("day", DayHolder);
                    params.put("description", DescriptionHolder);
                    params.put("amount", AmountHolder);
                    params.put("place", PlaceHolder);
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return " Into Entry";
            }
        } else if (key.equals(BUDGET)) {
            final String NameHolder;
            final String CatHolder;
            final String YearHolder;
            final String MonthHolder;
            final String DayHolder;
            final String UserGenHolder;
            final String AmountHolder;
            try {
                NameHolder = strings[1];
                CatHolder = strings[2];
                YearHolder = strings[3];
                MonthHolder = strings[4];
                DayHolder = strings[5];
                UserGenHolder = strings[6];
                AmountHolder = strings[7];
            } catch (Exception e) {
                return "Not Enough Information Given";
            }
            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "insertBudget.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response+" Into Budget");
                            Log.d("Response", response);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // error
                            storeResponse(error.toString()+" For Budget");
                            Log.d("Error.Response", error.toString());
                        }
                    }
            ) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", NameHolder);
                    params.put("category", CatHolder);
                    params.put("year", YearHolder);
                    params.put("month", MonthHolder);
                    params.put("day", DayHolder);
                    params.put("userGenerated", UserGenHolder);
                    params.put("amount", AmountHolder);
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return fromWeb+" Into Budget";
            }
        } else if (key.equals(USER)) {
            final String NameHolder;
            final String PasswordHolder;
            try {
                NameHolder = strings[1];
                PasswordHolder = strings[2];
            } catch (Exception e) {
                return "Not Enough Information Given";
            }
            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "insertUser.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response+" Into User");
                            Log.d("Response", response);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // error
                            storeResponse(error.toString()+" From User");
                            Log.d("Error.Response", error.toString());
                        }
                    }
            ) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", NameHolder);
                    params.put("password", PasswordHolder);
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return fromWeb+" Into User";
            }
        }
        return "Problem Inserting Data";
    }
}
