package io.github.olivenbarcelon.umws.controllers;

import java.time.LocalDateTime;
import java.time.ZoneId;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

import io.github.olivenbarcelon.umws.models.dtos.ApplicationDto;

@RestController
public class RootController {
    @Value("${application.name}")
    private String name;
    @Value("${application.version}")
    private String version;
    @Value("${application.timezone}")
    private String timezone;

    @GetMapping(path = "/info", produces = MediaType.APPLICATION_JSON_VALUE)
    public ResponseEntity<?> root() {
        ApplicationDto entity = new ApplicationDto();
        entity.setName(name);
        entity.setVersion(version);
        entity.setTimezone(timezone);
        entity.setTimestamp(LocalDateTime.now(ZoneId.of(timezone)));
        return ResponseEntity.ok(entity);
    }
}
