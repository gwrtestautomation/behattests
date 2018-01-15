@javascript
Feature: GWR Signup
  In order to use the Great Wolf Resorts Website features
  As a new user
  I need to sign up to the website

  Background:
    Given I have a web browser

  @insulated @F1S1
  Scenario: Enter invalid Email Address and check Sign up
    Given |I visit "Southern California Page"
    When |I click "Sign Up Link"
      And |I should see "Label on Sign Up Popup"
      And |I fill in "Email Address Textbox" with "qa.test"
      And |I fill in "First Name Textbox" with "QA"
      And |I fill in "Last Name Textbox" with "Test"
      And |I fill in "Postal Code Textbox" with "53717"
      And |I click "Create New Account Button"
    Then |I should see "Email Required Message"

  @insulated @F1S2
  Scenario: Enter valid details, check Sign up and validate welcome email
    Given |I visit "Southern California Page"
    When |I click "Sign Up Link"
     And |I should see "Label on Sign Up Popup"
     And |I fill in "Email Address Textbox" with dynamic "New Email Address"
     And |I fill in "First Name Textbox" with "QA"
     And |I fill in "Last Name Textbox" with "Test"
     And |I fill in "Postal Code Textbox" with "53717"
     And |I click "Create New Account Button"
    Then |I should "See Notification and User Logged In Successfully"
     And |I should receive a Welcome Email from Great Wolf Lodge

  @insulated @F1S3
  Scenario: Enter already registered Email Address and check Sign up
    Given |I visit "Southern California Page"
    When |I click "Sign Up Link"
    And |I should see "Label on Sign Up Popup"
    And |I fill in "Email Address Textbox" with dynamic "Registered Email Address"
    And |I fill in "First Name Textbox" with "QA"
    And |I fill in "Last Name Textbox" with "Test"
    And |I fill in "Postal Code Textbox" with "53717"
    And |I click "Create New Account Button"
    Then |I should see "Email Already Registered Message"

  @insulated @F1S4
  Scenario: User submits a new Canadian account
    Given |I visit "Niagara Page"
    When |I click "Sign Up Link"
      And |I should see "Label on Sign Up Popup"
      And |I fill in "Email Address Textbox" with dynamic "New Email Address"
      And |I fill in "First Name Textbox" with "QA"
      And |I fill in "Last Name Textbox" with "Test"
      And |I fill in "Postal Code Textbox" with "M3C 0C1"
      And |I check "I agree to receive Great Wolf Resorts emails Checkbox"
      And |I click "Create New Account Button"
    Then |I should "See Notification and User Logged In Successfully"
      And |I should receive a Welcome Email from Great Wolf Lodge