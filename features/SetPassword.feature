@javascript
Feature: Set Password
  In order to use the newly created Great Wolf Resorts account
  As a new user
  I need to set password from link received on email

  Background:
    Given I have a web browser

  @insulated @F2S1
  Scenario: Set password for a newly created account
    Given |I visit "Reset Password URL"
    When |I am on the "Reset Password Popup"
      And |I fill in "Password Textbox" with "Reset123"
      And |I fill in "Confirm Password Textbox" with "Reset123"
      And |I click "Reset Password Button"
    Then |I should "See Notification and User Logged In Successfully"