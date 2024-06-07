[![GuardRails badge](https://api.guardrails.io/v2/badges/206057?token=fae57e14f5515599caf899247d1b28bda1ce9b7e9614274c55344c38ed066a7f)](https://dashboard.guardrails.io/gh/olivenbarcelon/repos/206057)
[![codecov](https://codecov.io/gh/olivenbarcelon/um-ws/branch/master/graph/badge.svg?token=V6A57RJLG9)](https://codecov.io/gh/olivenbarcelon/um-ws)
# um-ws
User Management System

**Setup Repository**
* git clone https://github.com/olivenbarcelon/um-ws.git

**Setup Spring Application**
* spring init --build=maven --java-version=8 --dependencies=web --packaging=jar --groupId=io.github.olivenbarcelon --artifactId=um-ws --package-name=io.github.olivenbarcelon.umws -n=um-ws --description="User Management System" project --force

**Run Spring Application**
* mvn spring-boot:run -Dspring-boot.run.jvmArguments="-Dapplication.properties.path=classpath -Dspring.profiles.active=dev"
* mvn spring-boot:run -Dspring-boot.run.jvmArguments="-Dapplication.properties.path=classpath -Dspring.profiles.active=dev -Dlog4j2.configurationFile=file:/Users/olie/logs/log4j2.properties"

**Run Maven Test**
* mvn test -Dapplication.properties.path=classpath -Dspring.profiles.active=dev
* mvn test -Dapplication.properties.path=classpath -Dspring.profiles.active=dev -Dtest=UmWsApplicationTests#contextLoads
* mvn --batch-mode --update-snapshots verify -Dapplication.properties.path=classpath -Dspring.profiles.active=dev
