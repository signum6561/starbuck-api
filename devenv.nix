{ pkgs, ... }:

{
  packages = with pkgs; [
    git
  ];

  languages.php = {
    enable = true;
    version = "8.3";
    extensions = [
      "grpc"
      "protobuf"
      "curl"
      "openssl"
    ];
  };

}
