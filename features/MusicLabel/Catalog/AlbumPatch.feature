@album
Feature: Patching Albums
  In order to request PATCH /albums
  As an api-client
  I want to patch albums from the client-API

  Scenario: Patch an album. Endpoint with id in path
    Given I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "publishing_date": "1969-09-26 09:00:00"
      }
      """
    And the response status code should be "201"
    When I send a "PATCH" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "publishing_date": "1969-01-13 09:00:00"
      }
      """
    Then the response status code should be "204"
    And the JSON response should be equal to:
      """
      """

  Scenario: Patch an an non-existent album. Endpoint with id in path
    When I send a "PATCH" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "publishing_date": "1969-01-13 09:00:00"
      }
      """
    Then the response status code should be "404"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Patch an album without id uuid in path
    When I send a "PATCH" request to "/albums"
    Then the response status code should be "405"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Patch an album with wrong id uuid in path
    When I send a "PATCH" request to "/albums/wrong-id-here" with body:
      """
      {
          "title": "Yellow Submarine",
          "publishing_date": "1969-01-13 09:00:00"
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