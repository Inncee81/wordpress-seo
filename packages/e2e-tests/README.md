# Yoast E2E Tests package

e2e-tests implementation for Yoast SEO plugin.

## Usage

### Installation

1. Start by cloning this repository: `git clone https://github.com/Yoast/wordpress-seo.git`.
2. Then move to the repository folder `cd wordpress-seo`.
3. Checkout the e2e-tests branch by doing `git checkout try/e2e-tests-package`.
4. To install all the necessary dependencies, run the following commands:

> There are some conflicts that could happen with Puppeteer and newer versions of Node.
> Before running the following commands, please make sure your Node version is set to 12.
> This can be done through [nvm](https://github.com/nvm-sh/nvm), with the command `nvm use 12`.

```
composer install
yarn
grunt build:dev
```

5. Now you can start a WordPress local environment using [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/).

Make sure Docker is running on your machine and run `wp-env start` to launch the enviromnment.
Once you are done, you can run `wp-env start` to stop the local environment.

> The `wp-env start` and `wp-env stop` commands required to be run from the plugin root folder (wordpress-seo).
> To make it easier, you can run these commands from another terminal tab.

6. Move to the package folder by doing `cd packages/e2e-tests`.

7. Run the command `yarn test:e2e` to run the tests.

## Configuration

A configuration example is present in the [jest-puppeteer.config.js.example](jest-puppeteer.config.js.example) file.

The default configuration of the packages runs the test in headless mode. If you want to run the tests in headless mode, rename the `jest-puppeteer.config.js.example` file to `jest-puppeteer.config.js`

**Slow Motion** slows down Puppeteer operations by a specified amount of milliseconds.
Comment the `slowMo: 100,` line in `jest.puppeteer.config.js` to disable it. You can also edit the `slowMo` value to change its behaviour.