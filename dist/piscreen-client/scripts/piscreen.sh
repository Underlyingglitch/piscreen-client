#!/bin/bash

function piscreen() {
  if [$i = 'update']; then
    #Do update script
    echo "Update command"
  fi

  if [$i = 'uninstall']; then
    #Do uninstall script
    echo "Uninstall command"
  fi
}
