<?php
declare(strict_types=1);

namespace App\Plugins;

use Ramsey\Uuid\Uuid;

class UniqueID
{
    /**
     * RFC 4122定义了UUID的五个版本。每个版本都有不同的生成算法和属性。您选择使用哪一个取决于您的用例。您可以在该版本的特定页面上找到有关它们的应用程序的更多信息
     *
     * 版本1：基于时间
     * 此版本的UUID组合了时间戳，节点值（以本地计算机的网络接口中的MAC地址的形式）和时钟序列，以确保唯一性。
     *
     * 版本2：DCE安全
     * 该版本的UUID与版本1相同，不同之处clock_seq_low 在于该字段被替换为本地域，而该time_low字段被替换为本地标识符。
     *
     * 版本3：基于名称（MD5）
     * 此版本的UUID将名称空间和名称哈希在一起，以创建确定性的UUID。使用的哈希算法是MD5
     *
     * 版本4：随机
     * 此版本使用真实随机或伪随机数字创建UUID
     *
     * 版本5：基于名称（SHA-1）
     * 此版本的UUID将名称空间和名称哈希在一起，以创建确定性的UUID。使用的哈希算法是SHA-1
     *
     * @param string $prefix
     * @return string
     */
    public static function uuid($prefix = ''): string
    {
        return empty($prefix) ? Uuid::uuid1()->toString() : $prefix . Uuid::uuid1()->toString();
    }
}