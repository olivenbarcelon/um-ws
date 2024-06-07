package io.github.olivenbarcelon.umws.models.dtos;

import java.time.LocalDateTime;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class ApplicationDto {
    private String name;
    private String version;
    private String timezone;
    private LocalDateTime timestamp;
}
