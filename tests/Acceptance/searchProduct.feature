Feature: searchProduct
  In order to find stuff on the items page
  As a admin or employee
  I need to be able to input text and get results

Scenario: try search as admin
  Given I am on the "/User/index" page
  And I fill field "Nicole" in "username"
  And I fill field "1234" in "password"
  And I click "Sign in"
  And I click "Inventory"
  And I click "Products"
  And I click "Add Product"
  And I fill field "Super Yummy Ice Cream" in "name"
  And I fill field "This is ice cream." in "description"
  And I select "10" in "category"
  And I attach file "chocoIceCream.jpg" in "productPicture"
  And I click "action"
  And I fill field "Supper Yummy Ice Cream" in "search"
  When I click ".search-btn"
  Then I see "Super Yummy Ice Cream"
Scenario: try search as employee
  Given I am on the "/User/index" page
  And I fill field "Rachelle" in "username"
  And I fill field "1234" in "password"
  And I click "Sign in"
  And I click "Inventory"
  And I click "Products"
  And I fill field "Supper Yummy Ice Cream" in "search"
  When I click ".search-btn"
  Then I see "Super Yummy Ice Cream"