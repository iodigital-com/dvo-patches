<?php

namespace IoDigital\DvoPatches;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Util\ProcessExecutor;
use cweagans\Composer\Patch;
use cweagans\Composer\Patcher\PatcherInterface;

/**
 * A patcher that uses the system `patch` command with fuzz tolerance.
 *
 * Fallback for when git apply (zero fuzz) fails on patches with slightly
 * mismatched context lines.
 */
class PatchCommandPatcher implements PatcherInterface {

  /**
   * The main Composer instance.
   */
  protected Composer $composer;

  /**
   * IO interface for output.
   */
  protected IOInterface $io;

  /**
   * The plugin instance.
   */
  protected PluginInterface $plugin;

  /**
   * Process executor for running shell commands.
   */
  protected ProcessExecutor $executor;

  /**
   * {@inheritdoc}
   */
  public function __construct(Composer $composer, IOInterface $io, PluginInterface $plugin) {
    $this->composer = $composer;
    $this->io = $io;
    $this->plugin = $plugin;
    $this->executor = new ProcessExecutor($io);
  }

  /**
   * {@inheritdoc}
   */
  public function apply(Patch $patch, string $path): bool {
    $this->io->write("  Trying patch command on $path", TRUE, IOInterface::VERBOSE);

    $command = sprintf(
      'patch -p%s --no-backup-if-mismatch -d %s < %s 2>&1',
      $patch->depth,
      escapeshellarg($path),
      escapeshellarg($patch->localPath)
    );

    $output = '';
    $result = $this->executor->execute($command, $output);

    if ($result !== 0) {
      $this->io->write("  patch command failed", TRUE, IOInterface::VERBOSE);
      return FALSE;
    }

    if (str_contains($output, 'with fuzz') || str_contains($output, 'offset')) {
      $this->io->write(sprintf(
        '    <warning>Warning: patch %s applied with fuzz/offset to %s. The patch may need updating.</warning>',
        $patch->url,
        $patch->package
      ));
      foreach (explode("\n", trim($output)) as $line) {
        if (str_contains($line, 'fuzz') || str_contains($line, 'offset')) {
          $this->io->write("      $line");
        }
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function canUse(): bool {
    $output = '';
    return $this->executor->execute('patch --version', $output) === 0;
  }

}
