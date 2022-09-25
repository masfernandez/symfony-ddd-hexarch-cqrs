@auth
Feature: Managing Tokens
  In order to request /authentication endpoint
  As an api-client
  I want to managing user tokens

  Scenario: Login OK
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "email": "test@email.com",
        "password": "1234567890"
      }
      """
    Then the response status code should be "201"
    And the header "Location" should match "/^[\w\d]{64}$/"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Login KO
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "email": "test@email.com",
        "password": "wrong-password"
      }
      """
    Then the response status code should be "401"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Login without email
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "password": "1234567890"
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
            {
          "errors":[
              {
                  "source":{
                      "pointer": "/data/attributes/email"
                  },
                  "detail": "This field is missing."
              }
          ]
      }
      """

  Scenario: Login without password
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "email": "test@email.com"
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
            {
          "errors":[
              {
                  "source":{
                      "pointer": "/data/attributes/password"
                  },
                  "detail": "This field is missing."
              }
          ]
      }
      """

  Scenario: Login with additional xxx field
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "email": "test@email.com",
        "password": "1234567890",
        "xxx": "eyyy"
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
            {
          "errors":[
              {
                  "source":{
                      "pointer": "/data/attributes/xxx"
                  },
                  "detail": "This field was not expected."
              }
          ]
      }
      """

  Scenario: Login with empty password
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "email": "test@email.com",
        "password": ""
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
            {
          "errors":[
              {
                  "source":{
                      "pointer": "/data/attributes/password"
                  },
                  "detail": "This value is too short. It should have 1 character or more."
              },
              {
                  "source":{
                      "pointer": "/data/attributes/password"
                  },
                  "detail": "This value is too short. It should have 10 characters or more."
              }
          ]
      }
      """

  Scenario: Login with empty email
    When I send a "POST" request to "/authentication" with body:
      """
      {
        "email": "",
        "password": "1234567890"
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
            {
          "errors":[
              {
                  "source":{
                      "pointer": "/data/attributes/email"
                  },
                  "detail": "This value is too short. It should have 1 character or more."
              }
          ]
      }
      """