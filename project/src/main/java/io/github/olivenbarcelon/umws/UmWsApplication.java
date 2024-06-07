package io.github.olivenbarcelon.umws;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.PropertySource;
import org.springframework.core.SpringVersion;

import lombok.extern.log4j.Log4j2;

@SpringBootApplication
@Log4j2
@PropertySource("${application.properties}")
public class UmWsApplication {

    public static void main(String[] args) {
        SpringApplication.run(UmWsApplication.class, args);
        log.info("Spring Version: " + SpringVersion.getVersion());
    }
}
