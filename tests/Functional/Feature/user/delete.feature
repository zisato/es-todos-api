Feature:
  In order to use EsTodosApi
  I want to delete user

  Background: Creates user
    Given the following users exists:
    | id                                   | identification      | name      |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | User identification | User name |

  Scenario: It deletes successfully
    When I call "DELETE" "/users/3d900d32-8d47-11ea-bc55-0242ac130003"
    Then the status code should be 204
    And I call "GET" "/users/3d900d32-8d47-11ea-bc55-0242ac130003"
    Then the status code should be 404

  Scenario: It removes todos when delete user
    Given the following todos exists:
    | id                                   | user_id                              |  title     | description      |
    | b4c867fe-f822-4639-865a-9f9ca3835a42 | 3d900d32-8d47-11ea-bc55-0242ac130003 | Todo title | Todo description |
    When I call "DELETE" "/users/3d900d32-8d47-11ea-bc55-0242ac130003"
    Then the status code should be 204
    When I call "GET" "/todos/b4c867fe-f822-4639-865a-9f9ca3835a42"
    Then the status code should be 404
