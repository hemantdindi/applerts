package flink.datastream.applerts;

/**
 * Created by hemantd on 08/01/2016.
 */
public class AppPOJO {
    String id;
    String name;
    String user;
    String finalStatus;
    String trackingUrl;
    String applicationType;
    String startedTime;
    String finishedTime;
    String elapsedTime;
    String diagnostics;

    public AppPOJO() {    }
    public AppPOJO(String id,String name,String user,String finalStatus,String trackingUrl,String applicationType,String startedTime,String finishedTime,String elapsedTime,String diagnostics){
        setId(id);
        setName(name);
        setUser(user);
        setFinalStatus(finalStatus);
        setTrackingUrl(trackingUrl);
        setApplicationType(applicationType);
        setStartedTime(startedTime);
        setFinishedTime(finishedTime);
        setElapsedTime(elapsedTime);
        setDiagnostics(diagnostics);
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getUser() {
        return user;
    }

    public void setUser(String user) {
        this.user = user;
    }

    public String getFinalStatus() {
        return finalStatus;
    }

    public void setFinalStatus(String finalStatus) {
        this.finalStatus = finalStatus;
    }

    public String getTrackingUrl() {
        return trackingUrl;
    }

    public void setTrackingUrl(String trackingUrl) {
        this.trackingUrl = trackingUrl;
    }

    public String getApplicationType() {
        return applicationType;
    }

    public void setApplicationType(String applicationType) {
        this.applicationType = applicationType;
    }

    public String getStartedTime() {
        return startedTime;
    }

    public void setStartedTime(String startedTime) {
        this.startedTime = startedTime;
    }

    public String getFinishedTime() {
        return finishedTime;
    }

    public void setFinishedTime(String finishedTime) {
        this.finishedTime = finishedTime;
    }

    public String getElapsedTime() {
        return elapsedTime;
    }

    public void setElapsedTime(String elapsedTime) {
        this.elapsedTime = elapsedTime;
    }

    public String getDiagnostics() {
        return diagnostics;
    }

    public void setDiagnostics(String diagnostics) {
        this.diagnostics = diagnostics;
    }

    @Override
    public String toString() {
        return "AppPOJO{" +
                "\n id='" + id + '\'' +
                "\n name='" + name + '\'' +
                "\n user='" + user + '\'' +
                "\n finalStatus='" + finalStatus + '\'' +
                "\n trackingUrl='" + trackingUrl + '\'' +
                "\n applicationType='" + applicationType + '\'' +
                "\n startedTime='" + startedTime + '\'' +
                "\n finishedTime='" + finishedTime + '\'' +
                "\n elapsedTime='" + elapsedTime + '\'' +
                "\n diagnostics='" + diagnostics + '\'' +
                "\n" + '}';
    }
}
