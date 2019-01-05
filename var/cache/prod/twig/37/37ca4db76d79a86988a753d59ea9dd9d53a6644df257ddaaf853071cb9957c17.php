<?php

/* @PrestaShop/Admin/Module/Includes/modal_read_more.html.twig */
class __TwigTemplate_8183bbf7ba91ca9b8379b1d014e599c47532f413cd161236a7dcc94498b18461 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 25
        echo "<div id=\"module-modal-read-more-";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["module"] ?? null), "attributes", array()), "name", array()), "html", null, true);
        echo twig_escape_filter($this->env, (((isset($context["additionalModalSuffix"]) || array_key_exists("additionalModalSuffix", $context))) ? (_twig_default_filter(($context["additionalModalSuffix"] ?? null), "")) : ("")), "html", null, true);
        echo "\" class=\"modal modal-vcenter modal-read-more ps-modal-card fade\" role=\"dialog\">

</div>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Module/Includes/modal_read_more.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@PrestaShop/Admin/Module/Includes/modal_read_more.html.twig", "C:\\xampp\\htdocs\\presta\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Module\\Includes\\modal_read_more.html.twig");
    }
}
