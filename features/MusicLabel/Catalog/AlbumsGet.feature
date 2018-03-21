@album
Feature: Getting Albums paginated
  In order to request GET /albums
  As an api-client
  I want to get albums from the API

  Scenario: Get all albums. Default order and fields. There are 2 albums stored
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
    When I send a "GET" request to "/albums"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
    """
	  {
		"data": [
		  {
			"id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
			"title": "Abbey Road",
			"publishing_date": "1969-09-26 09:00:00"
		  },
		  {
			"id": "9be8b428-12ff-4312-806e-22547ea98dcb",
			"title": "Let It Be",
			"publishing_date": "1970-05-08 09:00:00"
		  }
		],
		"links": {
		  "self": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
		  "first": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
		  "prev": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
		  "next": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20",
		  "last": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=20"
		},
		"meta": {
		  "total_pages": 1
		}
	  }
	"""

  Scenario: Get all albums. Default order and fields. There are no albums stored
    When I send a "GET" request to "/albums"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
    """
      {
        "data":[],
        "links":[],
        "meta":{
          "total_pages":0
        }
      }
	"""

  Scenario: Get two albums from second page. Default order and fields. There are 4 albums stored
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
    Given I send a "POST" request to "/albums" with body:
    """
    {
        "id": "35d05db7-e52d-46f1-9ab9-201f0c0de42d",
        "title": "Yellow Submarine",
        "publishing_date": "1969-01-13 09:00:00"
    }
    """
    And the response status code should be "201"
    Given I send a "POST" request to "/albums" with body:
    """
      {
          "id": "1fb41120-03f5-44d1-8d61-a6dc7c243869",
          "title": "Revolver",
          "publishing_date": "1966-08-05 09:00:00"
      }
    """
    And the response status code should be "201"
    When I send a "GET" request to "/albums?page[number]=2&page[size]=2"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
    """
    {
      "data": [
        {
          "id": "1fb41120-03f5-44d1-8d61-a6dc7c243869",
          "title": "Revolver",
          "publishing_date": "1966-08-05 09:00:00"
        },
        {
          "id": "35d05db7-e52d-46f1-9ab9-201f0c0de42d",
          "title": "Yellow Submarine",
          "publishing_date": "1969-01-13 09:00:00"
        }
      ],
      "links": {
        "self": "/albums?page%5Bnumber%5D=2&page%5Bsize%5D=2",
        "first": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=2",
        "prev": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=2",
        "next": "/albums?page%5Bnumber%5D=2&page%5Bsize%5D=2",
        "last": "/albums?page%5Bnumber%5D=2&page%5Bsize%5D=2"
      },
      "meta": {
        "total_pages": 2
      }
    }
    """

  Scenario: Get three albums from first page. Ordered by publishing_date DESC.
    Show only publishing_date field. There are 4 o more albums stored
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
    Given I send a "POST" request to "/albums" with body:
    """
    {
        "id": "35d05db7-e52d-46f1-9ab9-201f0c0de42d",
        "title": "Yellow Submarine",
        "publishing_date": "1969-01-13 09:00:00"
    }
    """
    And the response status code should be "201"
    Given I send a "POST" request to "/albums" with body:
    """
      {
          "id": "1fb41120-03f5-44d1-8d61-a6dc7c243869",
          "title": "Revolver",
          "publishing_date": "1966-08-05 09:00:00"
      }
    """
    And the response status code should be "201"
    When I send a "GET" request to "/albums?page[number]=1&page[size]=3&fields[albums]=publishing_date&sort=-publishing_date"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
    """
    {
      "data": [
        {
          "publishing_date": "1970-05-08 09:00:00"
        },
        {
          "publishing_date": "1969-09-26 09:00:00"
        },
        {
          "publishing_date": "1969-01-13 09:00:00"
        }
      ],
      "links": {
        "self": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=3",
        "first": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=3",
        "prev": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=3",
        "next": "/albums?page%5Bnumber%5D=2&page%5Bsize%5D=3",
        "last": "/albums?page%5Bnumber%5D=2&page%5Bsize%5D=3"
      },
      "meta": {
        "total_pages": 2
      }
    }
    """

  Scenario: Get one album from third page. Ordered by publishing_date ASC.
    Show only id field. There are 4 albums stored
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
    Given I send a "POST" request to "/albums" with body:
    """
    {
        "id": "35d05db7-e52d-46f1-9ab9-201f0c0de42d",
        "title": "Yellow Submarine",
        "publishing_date": "1969-01-13 09:00:00"
    }
    """
    And the response status code should be "201"
    Given I send a "POST" request to "/albums" with body:
    """
      {
          "id": "1fb41120-03f5-44d1-8d61-a6dc7c243869",
          "title": "Revolver",
          "publishing_date": "1966-08-05 09:00:00"
      }
    """
    And the response status code should be "201"
    When I send a "GET" request to "/albums?page[number]=3&page[size]=1&fields[albums]=id&sort=publishing_date"
    Then the response status code should be "200"
    And the header "Content-Type" should contain "application/json"
    And the JSON response should be equal to:
    """
    {
      "data": [
        {
          "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2"
        }
      ],
      "links": {
        "self": "/albums?page%5Bnumber%5D=3&page%5Bsize%5D=1",
        "first": "/albums?page%5Bnumber%5D=1&page%5Bsize%5D=1",
        "prev": "/albums?page%5Bnumber%5D=2&page%5Bsize%5D=1",
        "next": "/albums?page%5Bnumber%5D=4&page%5Bsize%5D=1",
        "last": "/albums?page%5Bnumber%5D=4&page%5Bsize%5D=1"
      },
      "meta": {
        "total_pages": 4
      }
    }
    """
