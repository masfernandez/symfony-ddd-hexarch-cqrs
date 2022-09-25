@album
Feature: Creating Albums
  In order to request POST /albums
  As an api-client
  I want to create albums from the client-API

  Scenario: Create new album
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "201"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Create new album
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    Given There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "201"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Create new album without token
    When I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
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
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value is too short. It should have 1 character or more."},
            {
              "source":{
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should have exactly 64 characters."
            }
          ]
        }
      """

  Scenario: Create new album with too long token
    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPChpDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
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
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should have exactly 64 characters."
            }
          ]
        }
      """

  Scenario: Create new album with too short token
    When I add "Authorization" header equal to "pDV3EGM"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
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
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should have exactly 64 characters."
            }
          ]
        }
      """

  Scenario: Create new album without token
    When I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
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
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value is too short. It should have 1 character or more."},
            {
              "source":{
                "pointer":"\/data\/attributes\/token"
              },
              "detail":"This value should have exactly 64 characters."
            }
          ]
        }
      """

  Scenario: Create new album with wrong id
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/wrong-id-here" with body:
      """
      {
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
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

  Scenario: Create new album with wrong id
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "wrong-id-here",
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
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

  Scenario: Create new album with empty title
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "",
          "release_date": "1969-09-26T09:00:00+00:00",
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

  Scenario: Create new album with extra non existent field
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Abbey Road",
          "release_date": "1969-09-26T09:00:00+00:00",
          "non_existent_field": "value",
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
                      "pointer": "/data/attributes/non_existent_field"
                  },
                  "detail": "This field was not expected."
              }
          ]
      }
      """

  Scenario: Create new album with empty release_date
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Abbey Road",
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

  Scenario: Create new album with an already existing id
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is already an Album in database with id "9be8b428-12ff-4312-806e-22547ea98dcb" title "Let It Be" and release_date "1970-05-08T09:00:00+00:00"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb" with body:
      """
      {
          "title": "Let It Be",
          "release_date": "1970-05-08T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "409"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """


  Scenario: Create new album with an already existing id
    Given There is a user stored in database with id "332e7e35-d179-492d-a5f3-8702143fd777"
    And There is a VALID token with value "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh" associated to the user with id "332e7e35-d179-492d-a5f3-8702143fd777"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "release_date": "1970-05-08T09:00:00+00:00",
          "price": 12.95
      }
      """
    And the response status code should be "201"

    When I add "Authorization" header equal to "pDV3EGM9AE2KC7dDL9mlWMf17BJPlkf99ROOTIIAx4BWe5YP4JxmxSROVLZDsPCh"
    And I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "release_date": "1970-05-08T09:00:00+00:00",
          "price": 12.95
      }
      """
    Then the response status code should be "409"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """
