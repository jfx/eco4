*** Settings ***
Documentation     In order to be able to connect
...               As a anonymous user
...               I need to submit credentials
Test Setup        TestSetup
Test Teardown     Close All Browsers
Default Tags      login
Library           Selenium2Library
Resource          ../Common/Function/util.txt
Resource          ../Common/Function/action_ui.txt
Resource          Function/login.txt
Resource          Conf/login.txt

*** Test Cases ***
Anonymous user should see login page
    When I open browser on login page
    Then Page Should Contain    Login to eco4.io

Successfull user login
    Given I open browser on login page
    When I fill in and submit login form    ${user_username}    ${user_password}
    Then Page Should Contain    Dashboard
    And Page Should Not Contain    Admin

Successfull admin login
    Given I open browser on login page
    When I fill in and submit login form    ${admin_username}    ${admin_password}
    Then Page Should Contain    Dashboard
    And Page Should Contain    Admin

Locked user cannot login
    Given I open browser on login page
    When I fill in and submit login form    ${locked_username}    ${locked_password}
    Then Page Should Contain    Account is locked.

Wrong username
    Given I open browser on login page
    When I fill in and submit login form    wrong_username    ${user_password}
    Then Page Should Contain    Invalid credentials

Wrong password
    Given I open browser on login page
    When I fill in and submit login form    ${user_username}    wrong_password
    Then Page Should Contain    Invalid credentials

Wrong password for locked user
    Given I open browser on login page
    When I fill in and submit login form    ${locked_username}    wrong_password
    Then Page Should Contain    Account is locked.
