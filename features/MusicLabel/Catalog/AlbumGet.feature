@album
Feature: Getting Albums
  In order to request GET /albums
  As an api-client
  I want to get albums from the API

  Scenario: Get single album. There are 2 o more albums stored
    Given There are some albums stored in database:
      |  id                                     | title        | publishing_date        |
      |  0da69030-3ed7-42b5-8aa5-25fb61dab1b2   |  Abbey Road  | 1969-09-26 09:00:00    |
      |  9be8b428-12ff-4312-806e-22547ea98dcb   |  Let It Be   | 1970-05-08 09:00:00    |

    When I send a "GET" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {
        "data": {
          "id": "9be8b428-12ff-4312-806e-22547ea98dcb",
          "title": "Let It Be",
          "publishing_date": "1970-05-08 09:00:00"
        }
      }
      """

  Scenario: Get single album. There are no albums stored
    When I send a "GET" request to "/albums/9be8b428-12ff-4312-806e-22547ea98dcb"
    Then the response status code should be "404"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {
        "data": []
      }
      """

  Scenario: Get single album with wrong id
    When I send a "GET" request to "/albums/wrong-id-here"
    Then the response status code should be "400"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
      """
      {
          "errors":[
              {
                  "source":{
                      "pointer":"\/data\/attributes\/"
                  },
                  "detail":"This is not a valid UUID."
              }
          ]
      }
      """