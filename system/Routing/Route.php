<?php
namespace System\Routing;

class Route
{
    public string $compiledPath;

    public function __construct(
        public string $path,
        public string $handler,
        public string $method,
        public bool $enabled
    ) {
        $this->compiledPath = $this->compilePath($path);
    }

    protected function compilePath(string $pattern)
    {
        if (preg_match("/[^-:\/_{}()a-zA-Z\d]/", $pattern))
            return false;

        $pattern = preg_replace("#\(/\)#", "/?", $pattern);
        $allowedParamChars = "[a-zA-Z0-9\_\-]+";

        $pattern = preg_replace(
            "/:(" . $allowedParamChars . ")/",
            "(?<$1>" . $allowedParamChars . ")",
            $pattern
        );

        $pattern = preg_replace(
            "/{(" . $allowedParamChars . ")}/",
            "(?<$1>" . $allowedParamChars . ")",
            $pattern
        );

        $patternAsRegex = "@^" . $pattern . "$@D";

        return $patternAsRegex;
    }
}