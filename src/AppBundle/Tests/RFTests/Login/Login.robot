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

Successfull user login by username
    Given I open browser on login page
    When I fill in and submit login form    ${user_username}    ${user_password}
    Then Page Should Contain    Dashboard
    And Page Should Not Contain    Admin

uccessfull user login by email
    Given I open browser on login page
    When I fill in and submit login form    ${user_email}    ${user_password}
    Then Page Should Contain    Dashboard
    And Page Should Not Contain    Admin

Successfull admin login by username
    Given I open browser on login page
    When I fill in and submit login form    ${admin_username}    ${admin_password}
    Then Page Should Contain    Dashboard
    And Page Should Contain    Admin

Successfull admin login by email
    Given I open browser on login page
    When I fill in and submit login form    ${admin_email}    ${admin_password}
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

Wrong email
    Given I open browser on login page
    When I fill in and submit login form    wrong_email@example.com    ${user_password}
    Then Page Should Contain    Invalid credentials

Wrong password for username
    Given I open browser on login page
    When I fill in and submit login form    ${user_username}    wrong_password
    Then Page Should Contain    Invalid credentials

Wrong password for email
    Given I open browser on login page
    When I fill in and submit login form    ${user_email}    wrong_password
    Then Page Should Contain    Invalid credentials

Wrong password for locked user
    Given I open browser on login page
    When I fill in and submit login form    ${locked_username}    wrong_password
    Then Page Should Contain    Account is locked.

Successfull user login with redirect after timeout
    [Tags]    timeout
    [Setup]    TestLifetimeSetup
    Given I open browser on login page
    And I fill in and submit login form    ${user_username}    ${user_password}
    And I am waiting for timeout
    And Go To    ${SERVER}/profile
    And Location Should Be    ${LOGIN_URL}
    When I fill in and submit login form    ${user_username}    ${user_password}
    Then Location Should Be    ${SERVER}/profile/
    [Teardown]    TestLifetimeTeardown

Successfull login with remember me
    [Tags]    timeout
    [Setup]    TestLifetimeSetup
    Given I open browser on login page
    Input Text    username    ${user_username}
    Input Text    password    ${user_password}
    And Select Checkbox    remember_me
    And Click element    _submit
    And I am waiting for timeout
    When Go To    ${SERVER}/home
    Then Location Should Be    ${SERVER}/home
    [Teardown]    TestLifetimeTeardown
