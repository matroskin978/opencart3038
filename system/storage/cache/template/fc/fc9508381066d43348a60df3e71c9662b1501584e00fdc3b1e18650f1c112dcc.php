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

/* common/column_left.twig */
class __TwigTemplate_8f5428e7ae4dbb0e583133d50da40399cb9ae19e8722f17f0a3bbcbb0e82542a extends \Twig\Template
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
        echo "<ul class=\"list-group\">
  ";
        // line 2
        if ((twig_slice($this->env, ($context["route"] ?? null), 0, 8) != "upgrade/")) {
            // line 3
            echo "  ";
            if ((($context["route"] ?? null) == "install/step_1")) {
                // line 4
                echo "  <li class=\"list-group-item\"><b>";
                echo ($context["text_license"] ?? null);
                echo "</b></li>
  ";
            } else {
                // line 6
                echo "  <li class=\"list-group-item\">";
                echo ($context["text_license"] ?? null);
                echo "</li>
  ";
            }
            // line 8
            echo "  ";
            if ((($context["route"] ?? null) == "install/step_2")) {
                // line 9
                echo "  <li class=\"list-group-item\"><b>";
                echo ($context["text_installation"] ?? null);
                echo "</b></li>
  ";
            } else {
                // line 11
                echo "  <li class=\"list-group-item\">";
                echo ($context["text_installation"] ?? null);
                echo "</li>
  ";
            }
            // line 13
            echo "  ";
            if ((($context["route"] ?? null) == "install/step_3")) {
                // line 14
                echo "  <li class=\"list-group-item\"><b>";
                echo ($context["text_configuration"] ?? null);
                echo "</b></li>
  ";
            } else {
                // line 16
                echo "  <li class=\"list-group-item\">";
                echo ($context["text_configuration"] ?? null);
                echo "</li>
  ";
            }
            // line 18
            echo "  ";
        } else {
            // line 19
            echo "  ";
            if ((($context["route"] ?? null) == "upgrade/upgrade")) {
                // line 20
                echo "  <li class=\"list-group-item\"><b>";
                echo ($context["text_upgrade"] ?? null);
                echo "</b></li>
  ";
            } else {
                // line 22
                echo "  <li class=\"list-group-item\">";
                echo ($context["text_upgrade"] ?? null);
                echo "</li>
  ";
            }
            // line 24
            echo "  ";
            if ((($context["route"] ?? null) == "upgrade/upgrade/success")) {
                // line 25
                echo "  <li class=\"list-group-item\"><b>";
                echo ($context["text_finished"] ?? null);
                echo "</b></li>
  ";
            } else {
                // line 27
                echo "  <li class=\"list-group-item\">";
                echo ($context["text_finished"] ?? null);
                echo "</li>
  ";
            }
            // line 29
            echo "  ";
        }
        // line 30
        echo "</ul>
<form action=\"";
        // line 31
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"language\">
  <ul class=\"list-group\">
    <li class=\"list-group-item\">
      <div class=\"dropdown\">
        <button class=\"btn btn-default dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">";
        // line 35
        echo ($context["text_language"] ?? null);
        echo " <span class=\"caret\"></span></button>
        <ul class=\"dropdown-menu\">
          ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 38
            echo "          <li><a href=\"";
            echo $context["language"];
            echo "\"><img src=\"language/";
            echo $context["language"];
            echo "/";
            echo $context["language"];
            echo ".png\" /></a></li>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "        </ul>
      </div>
    </li>
  </ul>
  <input type=\"hidden\" name=\"code\" value=\"\" />
  <input type=\"hidden\" name=\"redirect\" value=\"";
        // line 45
        echo ($context["redirect"] ?? null);
        echo "\" />
</form>
<script type=\"text/javascript\"><!--
// Language
\$('#language a').on('click', function(e) {
\te.preventDefault();

\t\$('#language input[name=\\'code\\']').val(\$(this).attr('href'));

\t\$('#language').submit();
});
--></script> 
";
    }

    public function getTemplateName()
    {
        return "common/column_left.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  162 => 45,  155 => 40,  142 => 38,  138 => 37,  133 => 35,  126 => 31,  123 => 30,  120 => 29,  114 => 27,  108 => 25,  105 => 24,  99 => 22,  93 => 20,  90 => 19,  87 => 18,  81 => 16,  75 => 14,  72 => 13,  66 => 11,  60 => 9,  57 => 8,  51 => 6,  45 => 4,  42 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/column_left.twig", "");
    }
}
