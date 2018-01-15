<?php
/**
 * Created by PhpStorm.
 * User: madhav
 * * Date: 22-12-2017
 * Time: 13:17
 */

class ElementLocatorsContext
{

    static function getElementLocator($locator)
    {
        if ($locator === 'Sign Up Link')
        {
            $locator = "#header > div > div > div > div.panel-pane.pane-site-utlity.utility_second.mobile-include-menu.ng-scope > div > ul > li:nth-child(7) > a";
        } elseif ($locator === 'Label on Sign Up Popup')
        {
            $locator ="//*[@id='modal-header']/h2";
        }elseif ($locator === 'Email Address Textbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-email-address']";
        }elseif ($locator === 'First Name Textbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-first-name']";
        }elseif ($locator === 'Last Name Textbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-last-name']";
        }elseif ($locator === 'Postal Code Textbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-postal-code']";
        }elseif ($locator === 'Create New Account Button')
        {
            $locator ="#create-account-button";
        }elseif ($locator === 'Email Required Message')
        {
            $locator ="//*[@id='modal-main']/descendant::p[text()='Email field is required']";
        }elseif ($locator === 'Email Already Registered Message')
        {
            $locator ="//*[@id='modal-main']/descendant::p[text()='An account is already associated with this email address']";
        }elseif ($locator === 'See Notification and User Logged In Successfully')
        {
            $locator ="//*[@id='header']/descendant::a[@ng-model='vm.profile.first_name']";
        }elseif ($locator === 'Your MyGreatWolf account has been successfully created.')
        {
            $locator ="//*[@id='ng-app']/descendant::p[text()='Your MyGreatWolf account has been successfully created.']";
        }elseif ($locator === 'I agree to receive Great Wolf Resorts emails Checkbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-casl-opt-in']";
        }elseif ($locator === 'Reset Password Popup')
        {
            $locator ="//*[@id='modal-header']/h2";
        } elseif ($locator === 'Password Textbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-password']";
        }elseif ($locator === 'Confirm Password Textbox')
        {
            $locator ="//*[@name='modal-form']/descendant::input[@id='modal-confirm-password']";
        }elseif ($locator === 'Reset Password Button')
        {
            $locator ="#reset-password-button";
        }

        return $locator;
    }
}