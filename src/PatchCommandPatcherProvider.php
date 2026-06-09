<?php

namespace IoDigital\DvoPatches;

use cweagans\Composer\Capability\Patcher\BasePatcherProvider;

/**
 * Provides the patch-command patcher to composer-patches.
 */
class PatchCommandPatcherProvider extends BasePatcherProvider {

  /**
   * {@inheritdoc}
   */
  public function getPatchers(): array {
    return [
      new PatchCommandPatcher($this->composer, $this->io, $this->plugin),
    ];
  }

}
