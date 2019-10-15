# uk.co.mountev.mailingpermissions

![Screenshot](/images/screenshot.png)

Extension to restrict from-address and mailing recipient groups based on permissions configured. Extension will work even if "View/Edit All Conatcts" permission has been granted.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.6+
* CiviCRM v5.0+

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl uk.co.mountev.mailingpermissions@https://github.com/FIXME/uk.co.mountev.mailingpermissions/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/uk.co.mountev.mailingpermissions.git
cv en mailingpermissions
```

## Usage

* Goto Administer > CiviMail >> Mailing Permissions.
* Configure permissions.
* Login with permissioned user.
* Create new mailing (traditional). From address and recipients groups should be restricted as configured.
