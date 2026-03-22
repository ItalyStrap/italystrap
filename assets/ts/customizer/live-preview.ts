/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your JavaScript should grab settings from customizer controls, and
 * then make any necessary changes to the page using native DOM APIs.
 *
 * {@link https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/}
 */
(function() {
  var body = document.body;

  function getElements(selector) {
    return document.querySelectorAll(selector);
  }

  function setInnerHtml(selector, value) {
    getElements(selector).forEach(function(element) {
      element.innerHTML = value;
    });
  }

  function setStyle(selector, property, value) {
    getElements(selector).forEach(function(element) {
      element.style.setProperty(property, value);
    });
  }

  function replaceClasses(selector, classesToRemove, classToAdd) {
    getElements(selector).forEach(function(element) {
      element.classList.remove.apply(element.classList, classesToRemove);
      if (classToAdd) {
        element.classList.add(classToAdd);
      }
    });
  }

  // @ts-ignore
  wp.customize("blogname", function(value) {
    value.bind(function(newval) {
      setInnerHtml(".brand-name", newval);
    });
  });

  // @ts-ignore
  wp.customize("background_color", function(value) {
    value.bind(function(newval) {
      body.style.setProperty("background-color", newval);
    });
  });

  /**
   * ==================================================
   *
   * Navigation settings
   *
   * ==================================================
   */

  // @ts-ignore
  wp.customize("navbar[type]", function(value) {
    value.bind(function(newval) {
      replaceClasses("nav.site-nav", ["is-dark", "is-light"], newval);
    });
  });

  // @ts-ignore
  wp.customize("navbar[position]", function(value) {
    value.bind(function(newval) {
      replaceClasses(
        "nav.site-nav",
        ["is-relative-top", "is-fixed-top", "is-fixed-bottom", "is-static-top"],
        newval
      );
    });
  });

  // @ts-ignore
  wp.customize("navbar[nav_width]", function(value) {
    value.bind(function(newval) {
      replaceClasses(".site-nav-wrapper", ["container"], newval);
    });
  });

  // @ts-ignore
  wp.customize("navbar[menus_width]", function(value) {
    value.bind(function(newval) {
      replaceClasses("nav > div", ["container-fluid", "container"], newval);
    });
  });

  // @ts-ignore
  wp.customize("display_navbar_brand", function(value) {
    value.bind(function(newval) {
      setStyle(".site-nav-brand", "color", newval);
    });
  });

  // @ts-ignore
  wp.customize("boxed", function(value) {
    value.bind(function(newval) {
      replaceClasses(".wrapper", ["boxed"], newval);
    });
  });

  // @ts-ignore
  wp.customize("breadcrumbs_show_on", function(value) {
    value.bind(function(newval) {
      var currentTemplate = body.dataset.currentTemplate;
      var templateList = newval ? newval.split(",") : [];

      getElements(".breadcrumb").forEach(function(element) {
        element.style.display = templateList.indexOf(currentTemplate) !== -1 ? "" : "none";
      });
    });
  });

  // @ts-ignore
  wp.customize("404_title", function(value) {
    value.bind(function(newval) {
      setInnerHtml(".404-title", newval);
    });
  });

  // @ts-ignore
  wp.customize("404_content", function(value) {
    value.bind(function(newval) {
      setInnerHtml(".404-content", newval);
    });
  });

  // @ts-ignore
  wp.customize("colophon", function(value) {
    value.bind(function(newval) {
      setInnerHtml(".colophon-entry-content", newval);
    });
  });
})();
