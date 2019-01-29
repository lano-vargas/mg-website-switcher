<?php 
namespace Lano\WebsiteSwitcher\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
 
        $table = $setup->getConnection()->newTable(
            $setup->getTable('lano_custom')
        )->addColumn(
            'lano_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Lano Id'
        )->addColumn(
            'lano_fab_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Fab id from table lano_fab_custon'
        )->setComment(
            'Lano Custom Table'
        );
        $setup->getConnection()->createTable($table);

        $table1 = $setup->getConnection()->newTable(
            $setup->getTable('lano_fab_custom')
        )->addColumn(
            'fab_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Fab Id'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Name from table'
        )->setComment(
            'Fab Custom Table'
        );
        $setup->getConnection()->createTable($table1);
 
        $setup->endSetup();
    }
}