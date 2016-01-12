package flink.datastream.applerts.src;
import org.joda.time.format.DateTimeFormat      ;
import org.joda.time.format.DateTimeFormatter   ;
import java.io.InputStreamReader                ;
import java.net.HttpURLConnection               ;
import java.net.URL                             ;
import java.util.Locale                         ;
import javax.json.Json                          ;
import javax.json.JsonObject                    ;
import javax.json.JsonReader                    ;


public class FlinkJSONObject {

    private static transient DateTimeFormatter timeFormatter =
           DateTimeFormat.forPattern("yyyy-MM-DD HH:mm:ss").withLocale(Locale.US).withZoneUTC();
    public String jsonObject;
    public boolean isAccessible;
    public FlinkJSONObject(String link){
        try {
            URL url = new URL(link);
            HttpURLConnection httpconn = null;

                try {
                    httpconn = (HttpURLConnection) url.openConnection();
                    httpconn.setReadTimeout(1000 * 5); //Time Out Exception
                } catch (Exception e){
                    //Update the Logger
                    this.isAccessible = false;
                    this.jsonObject = null;
                    return;
                }

            httpconn.setRequestMethod("GET");
            httpconn.setRequestProperty("Accept", "application/json");
            if (httpconn.getResponseCode() != 200) {
                //Update the Logger
                this.isAccessible = false;
                this.jsonObject = null;
            } else {
                InputStreamReader istr = new InputStreamReader((httpconn.getInputStream()));
                JsonReader jsonReader = Json.createReader(istr);
                this.isAccessible = true;
                this.jsonObject = jsonReader.readObject().toString();
            }
        } catch (Exception e){
                //Update the Logger
            return;
        }
    }
}