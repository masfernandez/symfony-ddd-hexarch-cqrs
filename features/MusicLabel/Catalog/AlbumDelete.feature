@album
Feature: Deleting Albums
  In order to request DELETE /albums
  As an api-client
  I want to delete albums from API

  Scenario: Delete an album. Endpoint with id in path
    Given I send a "POST" request to "/albums" with body:
      """
      {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
          "title": "Abbey Road",
          "publishing_date": "1969-09-26 09:00:00"
      }
      """
    And the response status code should be "201"
    Given I send a "POST" request to "/albums" with body:
      """
      {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
      }
      """
    And the response status code should be "201"
    When I send a "DELETE" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb"
    Then the response status code should be "204"
    And the JSON response should be equal to:
      """
      """
    When I send a "GET" request to "/albums"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
        {
           "data":[
              {
                 "id":"0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
                 "title":"Abbey Road",
                 "publishing_date":"1969-09-26 09:00:00"
              }
           ],
           "links":{
              "self":"/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
              "first":"/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
              "prev":"/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
              "next":"/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
              "last":"/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20"
           },
           "meta":{
              "total_pages":1
           }
        }
      """

  Scenario: Delete an non-existent album. Endpoint with id in path
    When I send a "DELETE" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb"
    Then the response status code should be "404"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Delete an album without id uuid in path
    When I send a "DELETE" request to "/albums"
    Then the response status code should be "405"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {}
      """

  Scenario: Delete an album with wrong id uuid in path
    When I send a "DELETE" request to "/albums/wrong-id-here"
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