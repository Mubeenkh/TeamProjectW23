Feature: edituser
	In order to edit a user
	As a Itspecialist
	I have to click on edit user 

Scenario: try editing employee
	Given I am on the "/User/index" page
    And I fill field "itspecialist" in "username"
    And I fill field "1234" in "password"
    And I click "Sign in"
    And I see "List of Employee and Admin"
	And I click "testingUserEmployee"
	And I see "testingUserEmployee"
	And I click "Edit"
	And I click "#toggle-to-profile"
	And I fill field "testingUserEmployee" in "username"
	When I click "Back"
	Then I see "testingUserEmployee"