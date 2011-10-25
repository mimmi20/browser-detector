<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Using Twig template engine to output the form</title>
    <style type="text/css">
/* Set up custom font and form width */
body {
    margin-left: 10px;
    font-family: Arial,sans-serif;
    font-size: small;
}

.quickform {
    min-width: 500px;
    max-width: 600px;
    width: 560px;
}
{{ default_styles|raw }}
    </style>
{{ js_libraries|raw }}
  </head>
  <body>

{% if submitvalues %}
<pre>
{{ submitvalues|raw }}
</pre>
<hr />  
{% endif %}

    <div class="quickform"><form{{ form.attributes|raw }}>
      {% if form.hidden %}
      <div style="display: none;">
        {% for element in form.hidden %}
          {{ element|raw }}
        {% endfor %}
      </div>
      {% endif %}

{% macro output_element(element, ingroup) %}
  {% if 'fieldset' == element.type %}
    <fieldset{{ element.attributes|raw }}>
      <legend>{{ element.label }}</legend>
      {% for child in element.elements %}
        {{ _self.output_element(child) }}
      {% endfor %}
    </fieldset>
  {% elseif element.elements is defined %}
    <div class="row">
      <label class="element">
        {% if element.required %}<span class="required">* </span>{% endif %}
        {{ element.label }}
      </label>
      <div class="element group {% if element.error %} error{% endif %}">
        {% if element.error %}<span class="error">{{ element.error }}<br /></span>{% endif %}
        {% for child in element.elements %}
          {{ _self.output_element(child, true) }}
          {{ element.separator[loop.index0]|raw }}
        {% endfor %}
      </div>
    </div>
  {% elseif ingroup %}
    {{ element.html|raw }}
  {% else %}
    <div class="row">
      <label for="{{ element.id }}" class="element">
        {% if element.required %}<span class="required">* </span>{% endif %} 
        {{ element.label }}
      </label>
      <div class="element {% if element.error %} error{% endif %}">
          {% if element.error %}<span class="error">{{ element.error }}<br /></span>{% endif %}
          {{ element.html|raw }}
      </div>
    </div>
  {% endif %}
{% endmacro %}

      {% for element in form.elements %}
        {{ _self.output_element(element) }}
      {% endfor %}
    </form></div>
    {{ form.javascript|raw }}
  </body>
</html>
