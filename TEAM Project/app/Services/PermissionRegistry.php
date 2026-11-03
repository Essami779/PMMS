<?php

namespace App\Services;

class PermissionRegistry
{
    /**
     * Return defined system modules and permissions metadata.
     */
    public static function getModules(): array
    {
        return [
            'dashboard' => [
                'name' => 'لوحة التحكم والإحصائيات',
                'icon' => 'squares-2x2',
                'description' => 'الوصول إلى لوحة التحكم الرئيسية واستعراض الإحصائيات والمؤشرات ومتابعة أداء المنظومة',
                'permissions' => [
                    'dashboard.view' => [
                        'label' => 'عرض لوحة التحكم',
                        'description' => 'الاطلاع على لوحة التحكم الرئيسية والإحصائيات العامة',
                    ],
                ]
            ],
            'users' => [
                'name' => 'إدارة المستخدمين',
                'icon' => 'users',
                'description' => 'التحكم بحسابات المستخدمين، إنشاء وتعديل الحسابات، وتعيين الأدوار والصلاحيات',
                'permissions' => [
                    'users.manage' => [
                        'label' => 'إدارة حسابات المستخدمين',
                        'description' => 'إنشاء، تعديل، حذف، وتعيين أدوار وصلاحيات المستخدمين',
                    ],
                ]
            ],
            'roles' => [
                'name' => 'الأدوار والصلاحيات',
                'icon' => 'shield-check',
                'description' => 'إدارة الأدوار الوظيفية ومصفوفة الصلاحيات والتراخيص للمستخدمين',
                'permissions' => [
                    'roles.manage' => [
                        'label' => 'إدارة الأدوار ومصفوفة الصلاحيات',
                        'description' => 'إنشاء وتعديل وحذف الأدوار وتحديث مصفوفة الصلاحيات الشاملة',
                    ],
                ]
            ],
            'lookups' => [
                'name' => 'القوائم المساعدة والترميز',
                'icon' => 'table-cells',
                'description' => 'إدارة القوائم العامة (الوحدات والأقسام، المحافظات والمناطق، العملات وأسعار الصرف)',
                'permissions' => [
                    'lookups.manage' => [
                        'label' => 'إدارة القوائم المساعدة',
                        'description' => 'إضافة، تعديل، وحذف عناصر القوائم المساعدة والعملات في النظام',
                    ],
                ]
            ],
            'backups' => [
                'name' => 'النسخ الاحتياطي',
                'icon' => 'circle-stack',
                'description' => 'التحكم بالنسخ الاحتياطية لقواعد البيانات وملفات المشروع بالكامل',
                'permissions' => [
                    'backups.manage' => [
                        'label' => 'إدارة النسخ الاحتياطية',
                        'description' => 'إنشاء نسخ احتياطية (SQL/ZIP)، تنزيلها، رفعها، استعادتها أو حذفها',
                    ],
                ]
            ],
            'audit' => [
                'name' => 'سجل التدقيق والأمان',
                'icon' => 'shield-exclamation',
                'description' => 'مراقبة وتتبع السجلات والنشاطات الأمنية لكافة مستخدمي النظام',
                'permissions' => [
                    'audit.view' => [
                        'label' => 'استعراض سجل التدقيق',
                        'description' => 'عرض سجل النشاطات والعمليات المنفذة في المنظومة',
                    ],
                    'audit.delete' => [
                        'label' => 'مسح وحذف سجلات التدقيق',
                        'description' => 'حذف سجلات التدقيق والأمان الفردية أو المجمعة',
                    ],
                ]
            ],
            'trash' => [
                'name' => 'سلة المهملات والمحذوفات',
                'icon' => 'trash',
                'description' => 'إدارة العناصر المحذوفة مؤقتاً في النظام واستعادتها أو حذفها نهائياً',
                'permissions' => [
                    'trash.manage' => [
                        'label' => 'إدارة سلة المهملات',
                        'description' => 'استعراض واستعادة وحذف العناصر في سلة المهملات',
                    ],
                ]
            ],
        ];
    }

    /**
     * Flattened array of all permissions keys.
     */
    public static function getAllPermissions(): array
    {
        $all = [];
        foreach (self::getModules() as $module) {
            foreach ($module['permissions'] as $key => $details) {
                $all[] = $key;
            }
        }
        return $all;
    }

    /**
     * Map permission key to Arabic label.
     */
    public static function getLabel(string $permissionKey): string
    {
        foreach (self::getModules() as $module) {
            if (isset($module['permissions'][$permissionKey])) {
                return $module['permissions'][$permissionKey]['label'];
            }
        }
        return $permissionKey;
    }

    /**
     * Get predefined role Arabic descriptions and colors.
     */
    public static function getRoleMetadata(string $roleName): array
    {
        $metadata = [
            'Super Admin' => [
                'label' => 'مدير النظام العام',
                'description' => 'يمتلك كافة الصلاحيات المطلقة بالمنظومة بدون أي قيود.',
                'color' => 'rose',
                'icon' => 'crown',
            ],
            'Admin' => [
                'label' => 'مدير النظام',
                'description' => 'إدارة المستخدمين والأدوار والقوائم المساعدة والنسخ الاحتياطي.',
                'color' => 'indigo',
                'icon' => 'shield-check',
            ],
            'Manager' => [
                'label' => 'مدير عام / مسؤول',
                'description' => 'إدارة الوحدات والقوائم المساعدة ومتابعة الإحصائيات.',
                'color' => 'amber',
                'icon' => 'briefcase',
            ],
            'User' => [
                'label' => 'مستخدم النظام',
                'description' => 'استخدام شاشات ولوحة التحكم وفق الصلاحيات الممنوحة.',
                'color' => 'emerald',
                'icon' => 'user',
            ],
            'Viewer' => [
                'label' => 'مستعرض / مشاهد',
                'description' => 'صلاحية للاطلاع واستعراض المؤشرات العامة فقط.',
                'color' => 'sky',
                'icon' => 'eye',
            ],
        ];

        return $metadata[$roleName] ?? [
            'label' => $roleName,
            'description' => 'دور مخصص في النظام.',
            'color' => 'purple',
            'icon' => 'shield',
        ];
    }
}
