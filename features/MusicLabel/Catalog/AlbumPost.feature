@album
Feature: Creating Albums
  In order to request POST /albums
  As an api-client
  I want to create albums from the client-API

  Scenario: Trying to create an new album without token. Endpoint collection (without id in path)
    When I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
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
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should not be blank."},
            {
              "source":{
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should have exactly 64 characters."
            }
          ]
        }
      """

  Scenario: Trying to create an new album without token. Endpoint with id in path
    When I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
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
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should not be blank."},
            {
              "source":{
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should have exactly 64 characters."
            }
          ]
        }
      """

  Scenario: Create an new album. Endpoint without id in path
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    Given There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
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
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
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
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/wrong-id-here" with body:
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
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
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
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
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
              }
          ]
      }
      """

  Scenario: Create an new album with empty publishing_date. Endpoint with id in path
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
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
              }
          ]
      }
      """

  Scenario: Create an new album with an already existing id. Endpoint without id in path
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
      }
      """
    And the response status code should be "201"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
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
    Given There is already an Album in database with id "9be8b428-12ff-4312-806e-22547ea98dcb" title "Let It Be" and publishing_date "1970-05-08 09:00:00"
    And There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is VALID a token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb" with body:
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