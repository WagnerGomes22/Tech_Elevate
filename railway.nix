{ pkgs ? import (fetchTarball "https://github.com/NixOS/nixpkgs/archive/nixos-23.05.tar.gz") {} }:

pkgs.mkShell {
  buildInputs = [
    pkgs.php81
    pkgs.composer
    pkgs.nodejs
    pkgs.mysql
    pkgs.git
  ];
}
