@album
Feature: Creating Albums
  In order to request POST /albums
  As an api-client
  I want to create albums from the client-API

  Scenario: Create an new album. Endpoint without id in path
    When I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "publishing_date": "1969-09-26 09:00:00"
      }
      """
    Then the response status code should be "201"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Create an new album. Endpoint with id in path
    When I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Abbey Road",
          "publishing_date": "1969-09-26 09:00:00"
      }
      """
    Then the response status code should be "201"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Create an new album with wrong id. Endpoint with id in path
    When I send a "POST" request to "/albums/wrong-id-here" with body:
      """
      {
          "title": "Abbey Road",
          "publishing_date": "1969-09-26 09:00:00"
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

  Scenario: Create an new album with wrong id. Endpoint without id in path
    When I send a "POST" request to "/albums" with body:
      """
      {
          "id": "wrong-id-here",
          "title": "Abbey Road",
          "publishing_date": "1969-09-26 09:00:00"
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

  Scenario: Create an new album with empty title. Endpoint with id in path
    When I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "",
          "publishing_date": "1969-09-26 09:00:00"
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
              },
              {
                  "source": {
                      "pointer": "/data/attributes/title"
                  },
                  "detail": "This value is too short. It should have 1 character or more."
              }
          ]
      }
      """

  Scenario: Create an new album with empty publishing_date. Endpoint with id in path
    When I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Abbey Road",
          "publishing_date": ""
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
                      "pointer": "/data/attributes/publishing_date"
                  },
                  "detail": "This value should not be blank."
              },{
                  "source":{
                      "pointer":"\/data\/attributes\/publishing_date"
                  },
                  "detail":"This value is too short. It should have 1 character or more."
              }
          ]
      }
      """

  Scenario: Create an new album with an already existing id. Endpoint without id in path
    Given I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
      }
      """
    And the response status code should be "201"
    When I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
      }
      """
    Then the response status code should be "409"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Create an new album with an already existing id. Endpoint with id in path
    Given I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
      }
      """
    And the response status code should be "201"
    When I send a "POST" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb" with body:
      """
      {
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
      }
      """
    Then the response status code should be "409"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """