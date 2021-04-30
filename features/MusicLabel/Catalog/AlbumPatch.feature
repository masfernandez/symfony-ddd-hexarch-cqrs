@album
Feature: Patching Albums
  In order to request PATCH /albums
  As an api-client
  I want to patch albums from the client-API

  Scenario: Patch an album
    Given There are some albums stored in database:
      |  id                                     | title        | publishing_date        |
      |  0da69030-3ed7-42b5-8aa5-25fb61dab1b2   |  Abbey Road  | 1969-09-26 09:00:00    |

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

  Scenario: Patch an an non-existent album
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

  Scenario: Patch an album with empty title
    When I send a "PATCH" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "",
          "publishing_date": "1969-01-13 09:00:00"
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

  Scenario: Patch an album with a title longer than 60 allowed
    When I send a "PATCH" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "abcdefghijabcdefghijabcdefghijabcdefghijabcdefghijabcdefghija",
          "publishing_date": "1969-01-13 09:00:00"
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
                  "detail": "This value is too long. It should have 60 characters or less."
              }
          ]
      }
      """

  Scenario: Patch an album with a empty date
    When I send a "PATCH" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
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

  Scenario: Patch an album with a wrong date format
    When I send a "PATCH" request to "/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2" with body:
      """
      {
          "title": "Yellow Submarine",
          "publishing_date": "1969-01-13 09:00:00a"
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
                  "detail": "This value is not a valid datetime."
              }
          ]
      }
      """