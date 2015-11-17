OAuth2Server
============
### Grant, manage, and verify requests based on OAuth2 access tokens, in your MODX site.

Potential use cases include:
- Authenticate 3rd party services like Zapier
- Grant access to REST resources, only to verified consumers
- Release subscription resources only to verified subscribers
- Trigger actions on integrated platforms using authenticated REST hooks

## Security
The OAuth2Server Extra doesn't grant any permissions whatsoever, on its own. It only provides a way to grant, manage, revoke and verify *access tokens*. Call the Snippet `[[!verifyOAuth2]]` in your Resource/Template, and the Resource will return an unauthorized or error response, if the request isn't accompanied by a valid access token. You can choose to do whatever you like, with the verified request—the possibilities are endless.

## Usage
_The instructions below assume the default configuration for the OAuth2Server Extra._

### Granting an Access Token to a 3rd Party
1. Install the OAuth2Server Extra via the Extras Installer in MODX Revolution. Hard-refresh your manager window after installing, as with any Extra.
_NOTE: It's *highly* recommended to disable the `compress_js` and `compress_css` System Settings, and enable Friendly URLs, for the most reliable performance of this Extra._

2. Navigate to the OAuth2Server Custom Manager Page (CMP) via the Extras » Oauth2Server main menu item. You should see a page like this:
![OAuth2Server CMP](https://www.dropbox.com/s/hhx6eyqjv4m9869/Screenshot%202015-11-17%2000.15.30.png?dl=1)

3. Click the "Add Client" button. A modal window will appear:
![OAuth2Server Add Client Window](https://www.dropbox.com/s/ek3bekbmpg7npdi/Screenshot%202015-11-17%2000.27.47.png?dl=1)

4. Fill in the details for "Client ID" and "Redirect URI" (the two required fields). The 3rd party application (3PA) to which you want to grant access, should provide you with a Redirect URI, to which to send the authorization code. Enter that Redirect URI here, so the 3PA can receive the authorization code, and use it to gain an access token. You can leave the "Client Secret" field blank, and a hashed key will be generated for you. Click the "Save" button. 
_NOTE: at this time, on version 0.7.x, the "Grant Types" and "Scope" features are un-tested. Specifying those values may cause unexpected issues._

5. Provide the "Client ID" and "Client Secret" to your 3PA, along with the URL for your "Authorization Endpoint" and your "Token Controller". The OAuth2Server install process should have created two Resources, with the aliases "auth" and "tokens", respectively, for this purpose:
![OAuth2Server Authorization Resource](https://www.dropbox.com/s/5iarnurl8lnfa6v/Screenshot%202015-11-17%2000.30.41.png?dl=1)
Please ensure that the "Token Controller" uses a blank, or "(empty)" Template, and that the "Content Type" is set to "JSON". You can test this by viewing the Resource on the front-end. The extension should be ".json" and you should see nothing but a JSON response body. At version 0.7.x this was not reliably set on all test installations.

6. When the 3PA sends you to the Authorization Endpoint, you must be logged in to MODX as a member of the "Administrator" User Group, and if the correct URL parameters have been sent, you will see a form that looks like this:
![OAuth2Server Authorization Form](https://www.dropbox.com/s/j5329pccvj3kkoo/Screenshot%202015-11-17%2000.42.45.png?dl=1)
_NOTE: when requesting authorization, the 3PA must pass two URL parameters: `client_id`, which must match a "Client ID" in your site, and `response_type`, which must equal `code`._

7. Clicking "Yes" in the authorization form will send the authorization code to your 3PA. Your 3PA should then make a POST request to the "Token Controller", in order to exchange the authorization code for an access token.
_NOTE: when requesting an access token, the 3PA must pass four key-value-pairs in the POST request: `client_id`, which must match a "Client ID" in your site, `client_secret`, which must match the "Client Secret" for the "Client ID" provided, `grant_type`, which must equal `authorization_code`, and `code`, which would have been sent to the 3PA during step 6 above._

8. If everything has gone to plan, your 3PA should have received an access token. You can verify that an access token has been generated, by navigating to the "Access Tokens" tab of the OAuth2Server CMP:
![OAuth2Server Access Tokens CMP](https://www.dropbox.com/s/9ebycblmsu9uoou/Screenshot%202015-11-17%2001.01.11.png?dl=1)

### Verifying Requests via Access Token
Call the `[[!verifyOAuth2]]` Snippet in any Resource/Template, to which you want to restrict access to verified requests only. The Snippet accepts four properties:

1. `redirectUnauthorized` defaults to `1`, which returns either an "unauthorized", or an "error", response and exits the current process.

2. `redirectTo` defaults to `"unauthorized"`, and allows you to choose the type of response, for unverified requests.

3. `returnOnUnauthorized` defaults to `0`, which is what the Snippet will return if the request is unverified.

4. `returnOnSuccess` defaults to `1`, which is what the Snippet will return if the request is verified.

There are countless design patterns with which you can use this Snippet. Here are a few examples:

#### Use a conditional to show a Chunk only if the Snippet returns `1`.
```
[[[[!verifyOAuth2:is=`1`:then=`$secret_content`:else=`-`]]]]
```
_NOTE: the "four bracket" syntax, which ensures the "then" result will not be processed erroneously. The conditional returns a string, which either forms a Chunk tag or a MODX comment tag, which returns nothing. In this case, the default `redirectUnauthorized` action will also occur._

#### Call resource Snippets or Chunks after the verify Snippet.
```
[[!verifyOAuth2]][[!myJsonResponse]]
```
This could be used in a Resource, with "Content Type" set to "JSON". If the request is unverified, the default action will be to send an "Unauthorized" response and exit the current process. If verified, page rendering would continue and the next Snippet would execute.

#### Return static responses.
```
[[!verifyOAuth2? &redirectUnauthorized=`0` &returnOnUnauthorized=`{"success":false}` &returnOnSuccess=`{"success":true}`]]
```
This overrides much of the default behaviour. In this usage, *page rendering will continue regardless of verification!* The snippet will return the values passed to the `return...` properties. This may be an uncommon pattern, but it's there if you need it.

## Troubleshooting
Handing out access tokens is tricky business. As Jason Coward warned me, there are a lot of moving parts. 

One issue I ran into, is when the consuming 3PA sends the access token in the header, instead of _or in addition to_ the URL parameter, OAuth2Server will not verify the request, even if a valid access token is provided. This behaviour is determined in the underlying library. Hopefully in a future release I can figure out a workaround.

As I continue to find gotchas, both in the code and in the usage, I'll document them here—front and centre—and hopefully be able to apply fixes.

## Acknowledgements

- [Brent Shaffer](https://github.com/bshaffer)'s [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php) library is the heart of this Extra.
- [Jason Coward](https://github.com/opengeek) provided his usual prudent, insightful guidance. 
- The impeccable organization of [John Peca](https://github.com/theboxer)'s CMP code made it easy for me to steal, resulting in my first CMP. (ExtJS is hard!).
- [Ryan Thrash](https://github.com/rthrash) is always incredibly supportive.