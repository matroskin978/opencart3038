<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* install/step_3.twig */
class __TwigTemplate_84fcd79078686265e7481ba834551cb99844fa30a37f18ed5a125b3c3031da7a extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo ($context["header"] ?? null);
        echo "
<div class=\"container\">
  <header>
    <div class=\"row\">
      <div class=\"col-sm-6\">
        <h1 class=\"pull-left\">3
          <small>/4</small>
        </h1>
        <h3>";
        // line 9
        echo ($context["heading_title"] ?? null);
        echo "
          <br/>
          <small>";
        // line 11
        echo ($context["text_step_3"] ?? null);
        echo "</small>
        </h3>
      </div>
      <div class=\"col-sm-6\">
        <div id=\"logo\" class=\"pull-right hidden-xs\"><img src=\"view/image/logo.png\" alt=\"OpenCart\" title=\"OpenCart\"/></div>
      </div>
    </div>
  </header>
  ";
        // line 19
        if (($context["error_warning"] ?? null)) {
            // line 20
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
  ";
        }
        // line 24
        echo "  <div class=\"row\">
    <div class=\"col-sm-9\">
      <form action=\"";
        // line 26
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">
        <p>";
        // line 27
        echo ($context["text_db_connection"] ?? null);
        echo "</p>
        <fieldset>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-driver\">";
        // line 30
        echo ($context["entry_db_driver"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"db_driver\" id=\"input-db-driver\" class=\"form-control\">
                ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["drivers"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["driver"]) {
            // line 34
            echo "                  ";
            if ((($context["db_driver"] ?? null) == twig_get_attribute($this->env, $this->source, $context["driver"], "value", [], "any", false, false, false, 34))) {
                // line 35
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["driver"], "value", [], "any", false, false, false, 35);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["driver"], "text", [], "any", false, false, false, 35);
                echo "</option>
                  ";
            } else {
                // line 37
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["driver"], "value", [], "any", false, false, false, 37);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["driver"], "text", [], "any", false, false, false, 37);
                echo "</option>
                  ";
            }
            // line 39
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['driver'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "              </select>
              ";
        // line 41
        if (($context["error_db_driver"] ?? null)) {
            // line 42
            echo "                <div class=\"text-danger\">";
            echo ($context["error_db_driver"] ?? null);
            echo "</div>
              ";
        }
        // line 44
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-hostname\">";
        // line 47
        echo ($context["entry_db_hostname"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"db_hostname\" value=\"";
        // line 49
        echo ($context["db_hostname"] ?? null);
        echo "\" id=\"input-db-hostname\" class=\"form-control\"/>
              ";
        // line 50
        if (($context["error_db_hostname"] ?? null)) {
            // line 51
            echo "                <div class=\"text-danger\">";
            echo ($context["error_db_hostname"] ?? null);
            echo "</div>
              ";
        }
        // line 53
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-username\">";
        // line 56
        echo ($context["entry_db_username"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"db_username\" value=\"";
        // line 58
        echo ($context["db_username"] ?? null);
        echo "\" id=\"input-db-username\" class=\"form-control\"/>
              ";
        // line 59
        if (($context["error_db_username"] ?? null)) {
            // line 60
            echo "                <div class=\"text-danger\">";
            echo ($context["error_db_username"] ?? null);
            echo "</div>
              ";
        }
        // line 62
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-password\">";
        // line 65
        echo ($context["entry_db_password"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"password\" name=\"db_password\" value=\"";
        // line 67
        echo ($context["db_password"] ?? null);
        echo "\" id=\"input-db-password\" class=\"form-control\"/>
            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-database\">";
        // line 71
        echo ($context["entry_db_database"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"db_database\" value=\"";
        // line 73
        echo ($context["db_database"] ?? null);
        echo "\" id=\"input-db-database\" class=\"form-control\"/>
              ";
        // line 74
        if (($context["error_db_database"] ?? null)) {
            // line 75
            echo "                <div class=\"text-danger\">";
            echo ($context["error_db_database"] ?? null);
            echo "</div>
              ";
        }
        // line 77
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-port\">";
        // line 80
        echo ($context["entry_db_port"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"db_port\" value=\"";
        // line 82
        echo ($context["db_port"] ?? null);
        echo "\" id=\"input-db-port\" class=\"form-control\"/>
              ";
        // line 83
        if (($context["error_db_port"] ?? null)) {
            // line 84
            echo "                <div class=\"text-danger\">";
            echo ($context["error_db_port"] ?? null);
            echo "</div>
              ";
        }
        // line 86
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-db-prefix\">";
        // line 89
        echo ($context["entry_db_prefix"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"db_prefix\" value=\"";
        // line 91
        echo ($context["db_prefix"] ?? null);
        echo "\" id=\"input-db-prefix\" class=\"form-control\"/>
              ";
        // line 92
        if (($context["error_db_prefix"] ?? null)) {
            // line 93
            echo "                <div class=\"text-danger\">";
            echo ($context["error_db_prefix"] ?? null);
            echo "</div>
              ";
        }
        // line 95
        echo "            </div>
          </div>
        </fieldset>
        <p>";
        // line 98
        echo ($context["text_db_administration"] ?? null);
        echo "</p>
        <fieldset>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-username\">";
        // line 101
        echo ($context["entry_username"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"username\" value=\"";
        // line 103
        echo ($context["username"] ?? null);
        echo "\" id=\"input-username\" class=\"form-control\"/>
              ";
        // line 104
        if (($context["error_username"] ?? null)) {
            // line 105
            echo "                <div class=\"text-danger\">";
            echo ($context["error_username"] ?? null);
            echo "</div>
              ";
        }
        // line 107
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-password\">";
        // line 110
        echo ($context["entry_password"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"password\" value=\"";
        // line 112
        echo ($context["password"] ?? null);
        echo "\" id=\"input-password\" class=\"form-control\"/>
              ";
        // line 113
        if (($context["error_password"] ?? null)) {
            // line 114
            echo "                <div class=\"text-danger\">";
            echo ($context["error_password"] ?? null);
            echo "</div>
              ";
        }
        // line 116
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-email\">";
        // line 119
        echo ($context["entry_email"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"email\" value=\"";
        // line 121
        echo ($context["email"] ?? null);
        echo "\" id=\"input-email\" class=\"form-control\"/>
              ";
        // line 122
        if (($context["error_email"] ?? null)) {
            // line 123
            echo "                <div class=\"text-danger\">";
            echo ($context["error_email"] ?? null);
            echo "</div>
              ";
        }
        // line 125
        echo "            </div>
          </div>
        </fieldset>
        <div class=\"buttons\">
          <div class=\"pull-left\"><a href=\"";
        // line 129
        echo ($context["back"] ?? null);
        echo "\" class=\"btn btn-default\">";
        echo ($context["button_back"] ?? null);
        echo "</a></div>
          <div class=\"pull-right\">
            <input type=\"submit\" value=\"";
        // line 131
        echo ($context["button_continue"] ?? null);
        echo "\" class=\"btn btn-primary\"/>
          </div>
        </div>
      </form>
    </div>
    <div class=\"col-sm-3\">";
        // line 136
        echo ($context["column_left"] ?? null);
        echo "</div>
  </div>
</div>
";
        // line 139
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "install/step_3.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  355 => 139,  349 => 136,  341 => 131,  334 => 129,  328 => 125,  322 => 123,  320 => 122,  316 => 121,  311 => 119,  306 => 116,  300 => 114,  298 => 113,  294 => 112,  289 => 110,  284 => 107,  278 => 105,  276 => 104,  272 => 103,  267 => 101,  261 => 98,  256 => 95,  250 => 93,  248 => 92,  244 => 91,  239 => 89,  234 => 86,  228 => 84,  226 => 83,  222 => 82,  217 => 80,  212 => 77,  206 => 75,  204 => 74,  200 => 73,  195 => 71,  188 => 67,  183 => 65,  178 => 62,  172 => 60,  170 => 59,  166 => 58,  161 => 56,  156 => 53,  150 => 51,  148 => 50,  144 => 49,  139 => 47,  134 => 44,  128 => 42,  126 => 41,  123 => 40,  117 => 39,  109 => 37,  101 => 35,  98 => 34,  94 => 33,  88 => 30,  82 => 27,  78 => 26,  74 => 24,  66 => 20,  64 => 19,  53 => 11,  48 => 9,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "install/step_3.twig", "");
    }
}
