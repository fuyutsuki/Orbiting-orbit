<?php
namespace orbit;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Snowball;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDespawnEvent;
use pocketmine\level\Level;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;

class Main extends PluginBase implements Listener {

  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
  }

  /**
   * 雪玉を落とした時に実行
   * @param  EntityDespawnEvent $event
   */
  public function onEntityDespawn(EntityDespawnEvent $event) {
    if($event->getType() === 81){
      $entity = $event->getEntity();
      $level = $entity->getLevel();
      $x = $entity->getX();
      $y = $entity->getY();
      $z = $entity->getZ();
      /****************************************************/
      $ra = 10;  // 楕円長辺(a)
      $rb = 5;   // 楕円短辺(b)
      $s1 = 3;   // 傾き(変数)
      $s2 = 15;
      $d1 = 45;  // 元の楕円との角度差(度数法)
      $d2 = 180;
      $n  = 360; // 分割数
      for ($k = 1; $k < 360; ++$k) {
        $theta = 2*$k*M_PI/$n;
        // 媒介変数表示(x, z)
        $px = $x + $ra*cos($theta);
        $pz = $z + $rb*sin($theta);
        // y軸 一次式
        $py1 = $y + $s1*cos(2*($k + $d1)*M_PI/$n);
        $particle1 = new RedstoneParticle(new Vector3($px, $py1, $pz), 5);
        $level->addParticle($particle1);
        $py2 = $y + $s2*cos(2*($k + $d2)*M_PI/$n);
        $particle2 = new RedstoneParticle(new Vector3($px, $py2, $pz), 5);
        $level->addParticle($particle2);
      }
    }
  }
}
