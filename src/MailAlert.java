package flink.datastream.applerts.src;
import org.apache.commons.mail.*;
import org.apache.flink.api.java.utils.ParameterTool;
import org.apache.log4j.Logger;

/**
 * Created by hemantd on 18/01/2016.
 */
public class MailAlert {

    HtmlEmail email = null;
    final static Logger log     = Logger.getLogger(MailAlert.class);
    public boolean sendMail(AppPOJO ai, ParameterTool parameterTool, String recepient){
        boolean isDelivered=false;
        email = new HtmlEmail();
        String email_html_msg="";
        try {
            email.setHostName(parameterTool.getRequired("smtphost"));
            email.setSmtpPort(Integer.getInteger(parameterTool.getRequired("smtpport").trim()));
            email.setStartTLSEnabled(false);
            email.setFrom(parameterTool.getRequired("smtpsender"));
            email.setSubject("Applerts :: Application ID - "+ai.getId());

            email_html_msg="<html> " +
                    "<head> " +
                    "<style> " +
                    "table{ border-collapse: collapse; -webkit-box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75); -moz-box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75); box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75); } td { font-family:Lucida Console; font-size:12px; padding:5px; width:300px; border:1px solid rgb(66, 184, 221); } thead{ background: rgb(66, 184, 221); font-weight:bold; } " +
                    "</style> " +
                    "</head> " +
                    "<body> " +
                    "Hello Team, <br/><br/> An application failed today. Below are the details of the same: <br /><br />"+
                    "<table> " +
                    "<thead> " +
                    "<tr> " +
                    "<td>Application Property</td><td>Value</td> " +
                    "</tr> </thead> " +
                    "<tr> <td>Application ID                </td><td>"+ai.getId()+"</td> </tr>" +
                    "<tr> <td>Application Name              </td><td>"+ai.getName()+"</td> </tr>" +
                    "<tr> <td>Application User              </td><td>"+ai.getUser()+"</td> </tr>" +
                    "<tr> <td>Application Final Status      </td><td>"+ai.getFinalStatus()+"</td> </tr>" +
                    "<tr> <td>Application Start Time        </td><td>"+ai.getStartedTime()+"</td> </tr>" +
                    "<tr> <td>Application End Time          </td><td>"+ai.getFinishedTime()+"</td> </tr>" +
                    "<tr> <td>Application Elapsed Time      </td><td>"+ai.getElapsedTime()+" &nbsp;ms</td> </tr>" +
                    "<tr> <td>Application Diagnostics       </td><td>"+ai.getDiagnostics()+"</td> </tr>" +
                    "</table> " +
                    "<br /><br />" +
                    "Please get in touch with the <a href=\"mailto:hemantkumar.dindi@gmail.com\">Hadoop Platform Support Team</a> for more details." +
                    "<br/><br/>Thank You" +
                    "</body> </html>";
            email.setMsg(email_html_msg);
            if(recepient.equals("noemail"))
                email.addTo(parameterTool.getRequired("alertcc"));
            else
                email.addTo(recepient);
            email.send();
            isDelivered=true;
            log.info("Triggered alert for application : "+ai.getId());
        } catch (Exception e){
            log.error("Failed to deliver the email for application : " +ai.getId() +"\n"+e);
            isDelivered=false;
        }
        return isDelivered;
    }
}
