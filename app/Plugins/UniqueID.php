<?php
declare(strict_types=1);

namespace App\Plugins;

use Godruoyi\Snowflake\Snowflake;
use Ramsey\Uuid\Type\Hexadecimal;
use Ramsey\Uuid\Type\Integer as IntegerObject;
use Ramsey\Uuid\Uuid;

class UniqueID
{
    /**
     * @param string $prefix
     * @param null $node
     * @param int|null $clockSeq
     * @return string
     */
    public static function uuidV1($prefix = '', $node = null, ?int $clockSeq = null): string
    {
        //RFC 4122版本1：基于时间
        //此版本的UUID组合了时间戳，节点值（以本地计算机的网络接口中的MAC地址的形式）和时钟序列，以确保唯一性。
        $uuid = Uuid::uuid1($node, $clockSeq)->toString();
        return empty($prefix) ? $uuid : $prefix . $uuid;
    }

    public static function uuidV2(int $localDomain,
                                  ?IntegerObject $localIdentifier = null,
                                  ?Hexadecimal $node = null,
                                  ?int $clockSeq = null): string
    {
        //RFC 4122版本2：DCE安全
        //该版本的UUID与版本1相同，不同之处clock_seq_low 在于该字段被替换为本地域，而该time_low字段被替换为本地标识符。
        return Uuid::uuid2($localDomain, $localIdentifier, $node, $clockSeq)->toString();
    }

    public static function uuidV3($ns, string $name): string
    {
        //RFC 4122版本3：基于名称（MD5）
        //此版本的UUID将名称空间和名称哈希在一起，以创建确定性的UUID。使用的哈希算法是MD5
        return Uuid::uuid3($ns, $name)->toString();
    }

    public static function uuidV4(): string
    {
        //RFC 4122版本4：随机
        // 此版本使用真实随机或伪随机数字创建UUID
        return Uuid::uuid4()->toString();
    }

    public static function uuidV5($ns, string $name): string
    {
        //RFC 4122版本5：基于名称（SHA-1）
        //此版本的UUID将名称空间和名称哈希在一起，以创建确定性的UUID。使用的哈希算法是SHA-1
        return Uuid::uuid5($ns, $name)->toString();
    }

    public static function snowIdV1()
    {
        $snowFlake = new Snowflake();
    }
}