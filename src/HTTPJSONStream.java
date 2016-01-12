package flink.datastream.applerts.src;

import org.apache.flink.streaming.api.functions.source.SourceFunction;

public class HTTPJSONStream implements SourceFunction<FlinkJSONObject> {

    private final int maxDelayMsecs;
    private final String urlLink;
    private transient boolean status;

    public HTTPJSONStream(String urlLink) {
        this(urlLink, 60);
    }

    public HTTPJSONStream(String urlLink, int maxEventDelaySecs) {
        if(maxEventDelaySecs < 0) {
            throw new IllegalArgumentException("Max event delay must be positive");
        }
        this.urlLink = urlLink;
        this.maxDelayMsecs = maxEventDelaySecs * 1000;
    }

    @Override
    public void run(SourceContext<FlinkJSONObject> sourceContext) throws Exception {
        do {
            FlinkJSONObject fjo = new FlinkJSONObject(this.urlLink);
            sourceContext.collect(fjo);
            Thread.sleep(this.maxDelayMsecs); // maxDelayMsecs to be used here
            this.status=fjo.isAccessible;
        } while(this.status);
    }

    @Override
    public void cancel() {
       this.status=false;
    }

}