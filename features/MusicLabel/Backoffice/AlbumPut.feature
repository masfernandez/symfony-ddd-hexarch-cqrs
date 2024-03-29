@album
Feature: Updating (PUT) Albums
  In order to request PUT /albums
  As an api-client
  I want to update (put) albums from the client-API

  Scenario: Update an album
    Given There are some albums stored in database:
      | id                                   | title      | release_date              | price |
      | 0da69030-3ed7-42b5-8aa5-25fb61dab1b2 | Abbey Road | 1969-09-26T09:00:00+00:00 | 12.95 |

    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "release_date": "1969-01-13T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "400"
    And the JSON response should be equal to:
      """
        {
          "errors":[
            {
              "source":{
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value is not valid."
            }
          ]
        }
      """

  Scenario: Update a non-existent album
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    And I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "release_date": "1969-01-13T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "404"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Update an album without uuid in path
    When I send a "PUT" request to "/albums"
    Then the response status code should be "405"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Update an album with wrong uuid
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/wrong-id-here" with body:
      """
      {
          "title": "Yellow Submarine",
          "release_date": "1969-01-13T09:00:00+00:00",
          "price": 12.95
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
                      "pointer":"\/data\/attributes\/id"
                  },
                  "detail":"This is not a valid UUID."
              }
          ]
      }
      """

  Scenario: Update an album with empty title
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "",
          "release_date": "1969-01-13T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {
          "errors": [
              {
                  "source": {
                      "pointer": "/data/attributes/title"
                  },
                  "detail": "This value should not be blank."
              }
          ]
      }
      """

  Scenario: Update an album with a title longer than 255 allowed
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "abcdefghijabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijaabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijaabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijaabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijabcdefghijaabcdefghijabcde",
          "release_date": "1969-01-13T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {
          "errors": [
              {
                  "source": {
                      "pointer": "/data/attributes/title"
                  },
                  "detail": "This value is too long. It should have 255 characters or less."
              }
          ]
      }
      """

  Scenario: Update an album with a empty date
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "release_date": "",
          "price": 12.95
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
                      "pointer": "/data/attributes/release_date"
                  },
                  "detail": "This value should not be blank."
              }
          ]
      }
      """

  Scenario: Update an album with a wrong date format
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "release_date": "1969-01-13T09:00:00+00:00a",
          "price": 12.95
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
                      "pointer": "/data/attributes/release_date"
                  },
                  "detail": "This value is not a valid datetime."
              }
          ]
      }
      """

  Scenario: Update an album without title field
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "release_date": "1969-01-13T09:00:00+00:00",
          "price": 12.95
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
                      "pointer": "/data/attributes/title"
                  },
                  "detail": "This field is missing."
              }
          ]
      }
      """

  Scenario: Update an album without release_date field
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"
    Given There is VALID a JwToken for the user with id "332e7e35-d179-492d-a5f3-8702143fd777" email "test@email.com" password "1234567890"

    When I add "Authorization" header token value - JWT header and payload
    And I add cookie "signature" value - jwt signature
    When I send a "PUT" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "price": 12.95
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
                      "pointer": "/data/attributes/release_date"
                  },
                  "detail": "This field is missing."
              }
          ]
      }
      """