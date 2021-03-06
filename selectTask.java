package com.example.bryan.myapplication;

import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.w3c.dom.Text;

import java.util.HashMap;
import java.util.Map;

/**
 * Created by Bryan on 3/24/2018.
 */

public class selectTask extends AsyncTask<String, Void, String> {
    private final String ENTRY = "entry";
    private final String BUDGET = "budget";
    private final String USER = "user";
    private final String CATEGORY = "category";
    private AppCompatActivity main;
    private RequestQueue queue;
    private String fromWeb;
    private final String ServerURL = "http://default-environment.rfemrggswx.us-west-2.elasticbeanstalk.com/";
    private ProgressDialog myProgressDialog;

    selectTask(MainActivity activity) {
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
        myProgressDialog.setMessage("Attempting to select data...");
        myProgressDialog.setCancelable(false);
        myProgressDialog.show();
    }

    private void progressDialog_stop(){
        if(myProgressDialog != null) {
            myProgressDialog.dismiss();
        }
    }

    private void storeResponse(String response){
        Log.d("MAIN TASK", response);
        fromWeb = response;
        //TextView tv = main.findViewById(R.id.textViewSelectData);
        //tv.setText(fromWeb);
        Toast.makeText(main, fromWeb, Toast.LENGTH_SHORT).show();
        Log.d("MAIN TASK", fromWeb);
        progressDialog_stop();
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
        /*if (main != null) {
            Toast.makeText(main, s, Toast.LENGTH_SHORT).show();
        }
        detach();*/
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
            try {
                NameHolder = strings[1];
                CatHolder = strings[2];
                YearHolder = strings[3];
                MonthHolder = strings[4];
            } catch (Exception e) {
                return "Not Enough Information Given";
            }
            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "selectEntry.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response);
                            Log.d("Response", response);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // error
                            storeResponse(error.toString()+" From Entry");
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
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return fromWeb+"From Entry";
            }
        } else if (key.equals(BUDGET)) {
            final String NameHolder;
            final String CatHolder;

            try {
                NameHolder = strings[1];
                CatHolder = strings[2];
            } catch (Exception e) {
                return "Not Enough Information Given";
            }
            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "selectBudget.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response);
                            Log.d("Response", response);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // error
                            storeResponse(error.toString()+" From Budget");
                            Log.d("Error.Response", error.toString());
                        }
                    }
            ) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", NameHolder);
                    params.put("category", CatHolder);
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return fromWeb+" From Budget";
            }
        } else if (key.equals(USER)) {
            final String NameHolder;
            try {
                NameHolder = strings[1];
            } catch (Exception e) {
                return "Not Enough Information Given";
            }
            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "selectUser.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response);
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
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return fromWeb+" From User";
            }
        } else if (key.equals(CATEGORY)) {

            StringRequest postRequest = new StringRequest(Request.Method.POST, ServerURL + "selectCategory.php",
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            // response
                            storeResponse(response);
                            Log.d("Response", response);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // error
                            storeResponse(error.toString()+" From Category");
                            Log.d("Error.Response", error.toString());
                        }
                    }
            ) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    return params;
                }
            };
            if (main != null) {
                queue = Volley.newRequestQueue(main);
                queue.add(postRequest);
                return fromWeb+" From User";
            }
        }
        return "Problem Deleting Data";
    }
}
