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

/* install/step_2.twig */
class __TwigTemplate_88ac1122044e963c9e85fb75c6c15dbf4768c34ac0b388ff5431ee31418caa42 extends \Twig\Template
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
        <h1 class=\"pull-left\">2<small>/4</small></h1>
        <h3>";
        // line 7
        echo ($context["heading_title"] ?? null);
        echo "<br/>
          <small>";
        // line 8
        echo ($context["text_step_2"] ?? null);
        echo "</small></h3>
      </div>
      <div class=\"col-sm-6\">
        <div id=\"logo\" class=\"pull-right hidden-xs\"><img src=\"view/image/logo.png\" alt=\"OpenCart\" title=\"OpenCart\" /></div>
      </div>
    </div>
  </header>
  ";
        // line 15
        if (($context["error_warning"] ?? null)) {
            // line 16
            echo "  <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  </div>
  ";
        }
        // line 20
        echo "  <div class=\"row\">
    <div class=\"col-sm-9\">
      <form action=\"";
        // line 22
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\">
        <p>";
        // line 23
        echo ($context["text_install_php"] ?? null);
        echo "</p>
        <fieldset>
          <table class=\"table\">
            <thead>
              <tr>
                <td width=\"35%\"><b>";
        // line 28
        echo ($context["text_setting"] ?? null);
        echo "</b></td>
                <td width=\"25%\"><b>";
        // line 29
        echo ($context["text_current"] ?? null);
        echo "</b></td>
                <td width=\"25%\"><b>";
        // line 30
        echo ($context["text_required"] ?? null);
        echo "</b></td>
                <td width=\"15%\" class=\"text-center\"><b>";
        // line 31
        echo ($context["text_status"] ?? null);
        echo "</b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>";
        // line 36
        echo ($context["text_version"] ?? null);
        echo "</td>
                <td>";
        // line 37
        echo ($context["php_version"] ?? null);
        echo "</td>
                <td>7.3+</td>
                <td class=\"text-center\">";
        // line 39
        if ((($context["php_version"] ?? null) >= "7.3")) {
            // line 40
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 42
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 43
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 46
        echo ($context["text_global"] ?? null);
        echo "</td>
                <td>";
        // line 47
        if (($context["register_globals"] ?? null)) {
            // line 48
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 50
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 51
        echo "</td>
                <td>";
        // line 52
        echo ($context["text_off"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 53
        if ( !($context["register_globals"] ?? null)) {
            // line 54
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 56
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 57
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 60
        echo ($context["text_magic"] ?? null);
        echo "</td>
                <td>";
        // line 61
        if (($context["magic_quotes_gpc"] ?? null)) {
            // line 62
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 64
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 65
        echo "</td>
                <td>";
        // line 66
        echo ($context["text_off"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 67
        if ( !($context["error_magic_quotes_gpc"] ?? null)) {
            // line 68
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 70
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 71
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 74
        echo ($context["text_file_upload"] ?? null);
        echo "</td>
                <td>";
        // line 75
        if (($context["file_uploads"] ?? null)) {
            // line 76
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 78
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 79
        echo "</td>
                <td>";
        // line 80
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 81
        if (($context["file_uploads"] ?? null)) {
            // line 82
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 84
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 85
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 88
        echo ($context["text_session"] ?? null);
        echo "</td>
                <td>";
        // line 89
        if (($context["session_auto_start"] ?? null)) {
            // line 90
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 92
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 93
        echo "</td>
                <td>";
        // line 94
        echo ($context["text_off"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 95
        if ( !($context["session_auto_start"] ?? null)) {
            // line 96
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 98
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 99
        echo "</td>
              </tr>
            </tbody>
          </table>
        </fieldset>
        <p>";
        // line 104
        echo ($context["text_install_extension"] ?? null);
        echo "</p>
        <fieldset>
          <table class=\"table\">
            <thead>
              <tr>
                <td width=\"35%\"><b>";
        // line 109
        echo ($context["text_extension"] ?? null);
        echo "</b></td>
                <td width=\"25%\"><b>";
        // line 110
        echo ($context["text_current"] ?? null);
        echo "</b></td>
                <td width=\"25%\"><b>";
        // line 111
        echo ($context["text_required"] ?? null);
        echo "</b></td>
                <td width=\"15%\" class=\"text-center\"><b>";
        // line 112
        echo ($context["text_status"] ?? null);
        echo "</b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>";
        // line 117
        echo ($context["text_db"] ?? null);
        echo "</td>
                <td>";
        // line 118
        if (($context["db"] ?? null)) {
            // line 119
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 121
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 122
        echo "</td>
                <td>";
        // line 123
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 124
        if (($context["db"] ?? null)) {
            // line 125
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 127
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 128
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 131
        echo ($context["text_gd"] ?? null);
        echo "</td>
                <td>";
        // line 132
        if (($context["gd"] ?? null)) {
            // line 133
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 135
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 136
        echo "</td>
                <td>";
        // line 137
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 138
        if (($context["gd"] ?? null)) {
            // line 139
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 141
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 142
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 145
        echo ($context["text_curl"] ?? null);
        echo "</td>
                <td>";
        // line 146
        if (($context["curl"] ?? null)) {
            // line 147
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 149
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 150
        echo "</td>
                <td>";
        // line 151
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 152
        if (($context["curl"] ?? null)) {
            // line 153
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 155
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 156
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 159
        echo ($context["text_openssl"] ?? null);
        echo "</td>
                <td>";
        // line 160
        if (($context["openssl"] ?? null)) {
            // line 161
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 163
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 164
        echo "</td>
                <td>";
        // line 165
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 166
        if (($context["openssl"] ?? null)) {
            // line 167
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 169
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 170
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 173
        echo ($context["text_zlib"] ?? null);
        echo "</td>
                <td>";
        // line 174
        if (($context["zlib"] ?? null)) {
            // line 175
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 177
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 178
        echo "</td>
                <td>";
        // line 179
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 180
        if (($context["zlib"] ?? null)) {
            // line 181
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 183
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 184
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 187
        echo ($context["text_zip"] ?? null);
        echo "</td>
                <td>";
        // line 188
        if (($context["zip"] ?? null)) {
            // line 189
            echo "                  ";
            echo ($context["text_on"] ?? null);
            echo "
                  ";
        } else {
            // line 191
            echo "                  ";
            echo ($context["text_off"] ?? null);
            echo "
                  ";
        }
        // line 192
        echo "</td>
                <td>";
        // line 193
        echo ($context["text_on"] ?? null);
        echo "</td>
                <td class=\"text-center\">";
        // line 194
        if (($context["zip"] ?? null)) {
            // line 195
            echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
        } else {
            // line 197
            echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
        }
        // line 198
        echo "</td>
              </tr>
              ";
        // line 200
        if ( !($context["iconv"] ?? null)) {
            // line 201
            echo "              <tr>
                <td>";
            // line 202
            echo ($context["text_mbstring"] ?? null);
            echo "</td>
                <td>";
            // line 203
            if (($context["mbstring"] ?? null)) {
                // line 204
                echo "                  ";
                echo ($context["text_on"] ?? null);
                echo "
                  ";
            } else {
                // line 206
                echo "                  ";
                echo ($context["text_off"] ?? null);
                echo "
                  ";
            }
            // line 207
            echo "</td>
                <td>";
            // line 208
            echo ($context["text_on"] ?? null);
            echo "</td>
                <td class=\"text-center\">";
            // line 209
            if (($context["mbstring"] ?? null)) {
                // line 210
                echo "                  <span class=\"text-success\"><i class=\"fa fa-check-circle\"></i></span>
                  ";
            } else {
                // line 212
                echo "                  <span class=\"text-danger\"><i class=\"fa fa-minus-circle\"></i></span>
                  ";
            }
            // line 213
            echo "</td>
              </tr>
              ";
        }
        // line 216
        echo "            </tbody>
          </table>
        </fieldset>
        <p>";
        // line 219
        echo ($context["text_install_file"] ?? null);
        echo "</p>
        <fieldset>
          <table class=\"table\">
            <thead>
              <tr>
                <td><b>";
        // line 224
        echo ($context["text_file"] ?? null);
        echo "</b></td>
                <td><b>";
        // line 225
        echo ($context["text_status"] ?? null);
        echo "</b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>";
        // line 230
        echo ($context["catalog_config"] ?? null);
        echo "</td>
                <td>";
        // line 231
        if ( !($context["error_catalog_config"] ?? null)) {
            // line 232
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 234
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_catalog_config"] ?? null);
            echo "</span>
                  ";
        }
        // line 235
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 238
        echo ($context["admin_config"] ?? null);
        echo "</td>
                <td>";
        // line 239
        if ( !($context["error_admin_config"] ?? null)) {
            // line 240
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 242
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_admin_config"] ?? null);
            echo "</span>
                  ";
        }
        // line 243
        echo "</td>
              </tr>
            </tbody>
          </table>
        </fieldset>
        <p>";
        // line 248
        echo ($context["text_install_directory"] ?? null);
        echo "</p>
        <fieldset>
          <table class=\"table\">
            <thead>
              <tr>
                <td align=\"left\"><b>";
        // line 253
        echo ($context["text_directory"] ?? null);
        echo "</b></td>
                <td align=\"left\"><b>";
        // line 254
        echo ($context["text_status"] ?? null);
        echo "</b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>";
        // line 259
        echo ($context["image"] ?? null);
        echo "/</td>
                <td>";
        // line 260
        if ( !($context["error_image"] ?? null)) {
            // line 261
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 263
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_image"] ?? null);
            echo "</span>
                  ";
        }
        // line 264
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 267
        echo ($context["image_cache"] ?? null);
        echo "/</td>
                <td>";
        // line 268
        if ( !($context["error_image_cache"] ?? null)) {
            // line 269
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 271
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_image_cache"] ?? null);
            echo "</span>
                  ";
        }
        // line 272
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 275
        echo ($context["image_catalog"] ?? null);
        echo "/</td>
                <td>";
        // line 276
        if ( !($context["error_image_catalog"] ?? null)) {
            // line 277
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 279
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_image_catalog"] ?? null);
            echo "</span>
                  ";
        }
        // line 280
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 283
        echo ($context["cache"] ?? null);
        echo "/</td>
                <td>";
        // line 284
        if ( !($context["error_cache"] ?? null)) {
            // line 285
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 287
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_cache"] ?? null);
            echo "</span>
                  ";
        }
        // line 288
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 291
        echo ($context["logs"] ?? null);
        echo "/</td>
                <td>";
        // line 292
        if ( !($context["error_logs"] ?? null)) {
            // line 293
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 295
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_logs"] ?? null);
            echo "</span>
                  ";
        }
        // line 296
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 299
        echo ($context["download"] ?? null);
        echo "/</td>
                <td>";
        // line 300
        if ( !($context["error_download"] ?? null)) {
            // line 301
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 303
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_download"] ?? null);
            echo "</span>
                  ";
        }
        // line 304
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 307
        echo ($context["upload"] ?? null);
        echo "/</td>
                <td>";
        // line 308
        if ( !($context["error_upload"] ?? null)) {
            // line 309
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 311
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_upload"] ?? null);
            echo "</span>
                  ";
        }
        // line 312
        echo "</td>
              </tr>
              <tr>
                <td>";
        // line 315
        echo ($context["modification"] ?? null);
        echo "/</td>
                <td>";
        // line 316
        if ( !($context["error_modification"] ?? null)) {
            // line 317
            echo "                  <span class=\"text-success\">";
            echo ($context["text_writable"] ?? null);
            echo "</span>
                  ";
        } else {
            // line 319
            echo "                  <span class=\"text-danger\">";
            echo ($context["error_modification"] ?? null);
            echo "</span>
                  ";
        }
        // line 320
        echo "</td>
              </tr>
            </tbody>
          </table>
        </fieldset>
        <div class=\"buttons\">
          <div class=\"pull-left\"><a href=\"";
        // line 326
        echo ($context["back"] ?? null);
        echo "\" class=\"btn btn-default\">";
        echo ($context["button_back"] ?? null);
        echo "</a></div>
          <div class=\"pull-right\">
            <input type=\"submit\" value=\"";
        // line 328
        echo ($context["button_continue"] ?? null);
        echo "\" class=\"btn btn-primary\" />
          </div>
        </div>
      </form>
    </div>
    <div class=\"col-sm-3\">";
        // line 333
        echo ($context["column_left"] ?? null);
        echo "</div>
  </div>
</div>
";
        // line 336
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "install/step_2.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  905 => 336,  899 => 333,  891 => 328,  884 => 326,  876 => 320,  870 => 319,  864 => 317,  862 => 316,  858 => 315,  853 => 312,  847 => 311,  841 => 309,  839 => 308,  835 => 307,  830 => 304,  824 => 303,  818 => 301,  816 => 300,  812 => 299,  807 => 296,  801 => 295,  795 => 293,  793 => 292,  789 => 291,  784 => 288,  778 => 287,  772 => 285,  770 => 284,  766 => 283,  761 => 280,  755 => 279,  749 => 277,  747 => 276,  743 => 275,  738 => 272,  732 => 271,  726 => 269,  724 => 268,  720 => 267,  715 => 264,  709 => 263,  703 => 261,  701 => 260,  697 => 259,  689 => 254,  685 => 253,  677 => 248,  670 => 243,  664 => 242,  658 => 240,  656 => 239,  652 => 238,  647 => 235,  641 => 234,  635 => 232,  633 => 231,  629 => 230,  621 => 225,  617 => 224,  609 => 219,  604 => 216,  599 => 213,  595 => 212,  591 => 210,  589 => 209,  585 => 208,  582 => 207,  576 => 206,  570 => 204,  568 => 203,  564 => 202,  561 => 201,  559 => 200,  555 => 198,  551 => 197,  547 => 195,  545 => 194,  541 => 193,  538 => 192,  532 => 191,  526 => 189,  524 => 188,  520 => 187,  515 => 184,  511 => 183,  507 => 181,  505 => 180,  501 => 179,  498 => 178,  492 => 177,  486 => 175,  484 => 174,  480 => 173,  475 => 170,  471 => 169,  467 => 167,  465 => 166,  461 => 165,  458 => 164,  452 => 163,  446 => 161,  444 => 160,  440 => 159,  435 => 156,  431 => 155,  427 => 153,  425 => 152,  421 => 151,  418 => 150,  412 => 149,  406 => 147,  404 => 146,  400 => 145,  395 => 142,  391 => 141,  387 => 139,  385 => 138,  381 => 137,  378 => 136,  372 => 135,  366 => 133,  364 => 132,  360 => 131,  355 => 128,  351 => 127,  347 => 125,  345 => 124,  341 => 123,  338 => 122,  332 => 121,  326 => 119,  324 => 118,  320 => 117,  312 => 112,  308 => 111,  304 => 110,  300 => 109,  292 => 104,  285 => 99,  281 => 98,  277 => 96,  275 => 95,  271 => 94,  268 => 93,  262 => 92,  256 => 90,  254 => 89,  250 => 88,  245 => 85,  241 => 84,  237 => 82,  235 => 81,  231 => 80,  228 => 79,  222 => 78,  216 => 76,  214 => 75,  210 => 74,  205 => 71,  201 => 70,  197 => 68,  195 => 67,  191 => 66,  188 => 65,  182 => 64,  176 => 62,  174 => 61,  170 => 60,  165 => 57,  161 => 56,  157 => 54,  155 => 53,  151 => 52,  148 => 51,  142 => 50,  136 => 48,  134 => 47,  130 => 46,  125 => 43,  121 => 42,  117 => 40,  115 => 39,  110 => 37,  106 => 36,  98 => 31,  94 => 30,  90 => 29,  86 => 28,  78 => 23,  74 => 22,  70 => 20,  62 => 16,  60 => 15,  50 => 8,  46 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "install/step_2.twig", "");
    }
}
