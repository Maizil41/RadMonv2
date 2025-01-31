#!/bin/sh
# Radius Monitor V2 Auto Installer
# Author: Maizil <https://github.com/maizil41>

RED="\e[1;91m"
PURPLE="\e[1;95m"
CYAN="\e[1;96m"
YELLOW="\e[1;93m"
BLUE="\e[1;94m"
GREEN="\e[1;92m"
ORANGE="\e[1;91m"
PINK="\e[1;95m"
LIGHT_BLUE="\e[1;94m"
LIGHT_CYAN="\e[1;96m"
LIGHT_GREEN="\e[1;92m"
LIGHT_YELLOW="\e[1;93m"
GRAY="\e[0;37m"
LIGHT_GRAY="\e[0;37m"
BROWN="\e[0;33m"
RESET="\e[0m"

package_mariadb="mariadb-server mariadb-server-extra mariadb-client \
mariadb-client-extra libmariadb nano git git-http"

package_freeradius="libopenssl-legacy freeradius3 freeradius3-common freeradius3-default freeradius3-mod-always \
freeradius3-mod-attr-filter freeradius3-mod-chap freeradius3-mod-detail freeradius3-mod-digest freeradius3-mod-eap \
freeradius3-mod-eap-gtc freeradius3-mod-eap-md5 freeradius3-mod-eap-mschapv2 freeradius3-mod-eap-peap \
freeradius3-mod-eap-pwd freeradius3-mod-eap-tls freeradius3-mod-eap-ttls freeradius3-mod-exec \
freeradius3-mod-expiration freeradius3-mod-expr freeradius3-mod-files freeradius3-mod-logintime \
freeradius3-mod-mschap freeradius3-mod-pap freeradius3-mod-preprocess freeradius3-mod-radutmp \
freeradius3-mod-realm freeradius3-mod-sql freeradius3-mod-sql-mysql freeradius3-mod-sqlcounter \
freeradius3-mod-unix freeradius3-utils libfreetype wget-ssl curl unzip tar zoneinfo-asia"

package_php8="php8-cli php8-mod-mysqli php8-mod-pdo-mysql php8-mod-gd php8-mod-xml \
php8-mod-filter php8-mod-curl iptables-nft iptables-mod-hashlimit"

COLORS="$RED $PURPLE $CYAN $YELLOW $BLUE $GREEN $ORANGE $PINK $LIGHT_BLUE $LIGHT_CYAN $LIGHT_GREEN $LIGHT_YELLOW $GRAY $LIGHT_GRAY $BROWN"
COLOR_COUNT=$(echo "$COLORS" | wc -w)

get_random_color() {
    INDEX=$((RANDOM % COLOR_COUNT + 1))
    RANDOM_COLOR=$(echo "$COLORS" | awk -v idx=$INDEX '{print $idx}')
    echo "$RANDOM_COLOR"
}

show_banner() {
    clear
    echo -e "${CYAN}───────────────────────────────────────────────────────────${RESET}"
    echo -e "${PURPLE}██████╗  █████╗ ██████╗ ███╗   ███╗ ██████╗ ███╗   ██╗${RESET}"
    echo -e "${CYAN}██╔══██╗██╔══██╗██╔══██╗████╗ ████║██╔═══██╗████╗  ██║${RESET}"
    echo -e "${BLUE}██████╔╝███████║██║  ██║██╔████╔██║██║   ██║██╔██╗ ██║${RESET}"
    echo -e "${GREEN}██╔══██╗██╔══██║██║  ██║██║╚██╔╝██║██║   ██║██║╚██╗██║${RESET}"
    echo -e "${CYAN}██║  ██║██║  ██║██████╔╝██║ ╚═╝ ██║╚██████╔╝██║ ╚████║${RESET}"
    echo -e "${PURPLE}╚═╝  ╚═╝╚═╝  ╚═╝╚═════╝ ╚═╝     ╚═╝ ╚═════╝ ╚═╝  ╚═══╝${RESET}"
    echo -e "${CYAN}───────────────────────────────────────────────────────────${RESET}"
    echo -e "${RED}           RADIUS MONITOR V2 AUTO INSTALLER${RESET}"
    echo -e "${GREEN}             SCRIPT VERSION : 1.0 - beta${RESET}"
    echo -e "${BLUE}                   AUTHOR : Maizil${RESET}"
    echo -e "${CYAN}───────────────────────────────────────────────────────────${RESET}"
}

show_banner

echo -ne "${YELLOW}Apakah Anda ingin melanjutkan instalasi? (y/n): ${RESET}"
read -r pilihan

if [ "$pilihan" != "y" ]; then
    echo -e "${RED}Instalasi dibatalkan.${RESET}"
    exit 1
fi

show_banner
echo -e "$(get_random_color)Mengupdate Repository...${RESET}"
if ! opkg update >/dev/null 2>&1; then
    echo -e "${RED}Gagal mengupdate repository. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Setup Custom Repository${RESET}"

if ! grep -q "^# option check_signature" /etc/opkg.conf; then
    sed -i 's/option check_signature/# option check_signature/g' /etc/opkg.conf >/dev/null 2>&1
    echo -e "${YELLOW}Menonaktifkan pengecekan signature di /etc/opkg.conf...${RESET}"
fi

if ! grep -q "https://raw.githubusercontent.com/maizil41/mutiara-wrt-opkg/main/generic" /etc/opkg/customfeeds.conf; then
    echo "src/gz mutiara_wrt https://raw.githubusercontent.com/maizil41/mutiara-wrt-opkg/main/generic" >> /etc/opkg/customfeeds.conf >/dev/null 2>&1
    echo -e "${YELLOW}Menambahkan custom repository ke /etc/opkg/customfeeds.conf...${RESET}"
else
    echo -e "${YELLOW}Custom repository sudah ada. Melewati penambahan...${RESET}"
fi
show_banner

sleep 1

echo -e "$(get_random_color)Menginstall Package Mariadb...${RESET}"
if ! opkg install $package_mariadb >/dev/null 2>&1; then
    echo -e "${RED}Gagal menginstall paket Mariadb. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Menginstall Package Freeradius...${RESET}"
if ! opkg install $package_freeradius >/dev/null 2>&1; then
    echo -e "${RED}Gagal menginstall paket Freeradius. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Setting up Mariadb...${RESET}"
sed -i "s/option enabled '0'/option enabled '1'/g" /etc/config/mysqld && /etc/init.d/mysqld start
if ! /etc/init.d/mysqld status >/dev/null 2>&1; then
    echo -e "${RED}Gagal memulai Mariadb. Keluar...${RESET}"
    exit 1
fi
echo -e "$(get_random_color)Setting up MySQL...${RESET}"
{
echo "radmon"
echo "n"
echo "y"
echo "radmon"
echo "radmon"
echo "y"
echo "n"
echo "y"
echo "y"
} | mysql_secure_installation -u root
show_banner

sleep 1

echo -e "$(get_random_color)Menginstall Package Coova-Chilli...${RESET}"
if ! opkg install coova-chilli >/dev/null 2>&1; then
    echo -e "${RED}Gagal menginstall Coova-Chilli. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Menginstall Package PHP8..${RESET}"
if ! opkg remove libgd --force-depends >/dev/null 2>&1; then
    echo -e "${RED}Gagal menghapus libgd. Keluar...${RESET}"
    exit 1
fi
if ! opkg install $package_php8 >/dev/null 2>&1; then
    echo -e "${RED}Gagal menginstall paket PHP8. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Membuat Database...${RESET}"

if mysql -u root -pradmon -e "USE radmon" >/dev/null 2>&1; then
    echo -e "${YELLOW}Menghapus database radmon yang sudah ada...${RESET}"
    if ! mysql -u root -pradmon -e "DROP DATABASE radmon"; then
        echo -e "${RED}Gagal menghapus database radmon. Keluar...${RESET}"
        exit 1
    fi
fi

if ! mysql -u root -pradmon -e "CREATE DATABASE radmon CHARACTER SET utf8"; then
    echo -e "${RED}Gagal membuat database. Keluar...${RESET}"
    exit 1
fi

if ! mysql -u root -pradmon -e "GRANT ALL ON radmon.* TO 'radmon'@'localhost' IDENTIFIED BY 'radmon' WITH GRANT OPTION"; then
    echo -e "${RED}Gagal memberikan hak akses ke database. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Menghapus File Lama...${RESET}"
rm -f /etc/chilli/up.sh >/dev/null 2>&1
rm -rf /etc/freeradius3 >/dev/null 2>&1
rm -rf /etc/config/chilli >/dev/null 2>&1
rm -rf /etc/init.d/chilli >/dev/null 2>&1
rm -rf /usr/share/freeradius3 >/dev/null 2>&1
show_banner

sleep 1

echo -e "$(get_random_color)Mendownload File Baru...${RESET}"
cd / || { echo -e "${RED}Gagal masuk ke direktori root. Keluar...${RESET}"; exit 1; }
if ! wget https://raw.githubusercontent.com/Maizil41/Mutiara-Wrt/main/Bahan-Radmon.zip >/dev/null 2>&1; then
    echo -e "${RED}Gagal mendownload file. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1 

echo -e "$(get_random_color)Mengekstrak File Baru...${RESET}"
if ! unzip -o Bahan-Radmon.zip >/dev/null 2>&1; then
    echo -e "${RED}Gagal mengekstrak file. Keluar...${RESET}"
    exit 1
fi
rm -rf Bahan-Radmon.zip >/dev/null 2>&1
show_banner

sleep 1 

echo -e "$(get_random_color)Mengubah Permission...${RESET}"
chmod +x /etc/init.d/chilli >/dev/null 2>&1
chmod +x /usr/bin/radmon-* >/dev/null 2>&1
show_banner

sleep 1 

echo -e "$(get_random_color)Membuat Link www...${RESET}"
ln -sf /usr/share/RadMonv2 /www/RadMonv2
ln -sf /usr/share/hotspotlogin /www/hotspotlogin
ln -sf /usr/share/adminer /www/adminer
show_banner

sleep 1 

echo -e "$(get_random_color)Membuat Link mods-enabled...${RESET}"
cd /etc/freeradius3/mods-enabled || { echo -e "${RED}Gagal masuk ke direktori mods-enabled. Keluar...${RESET}"; exit 1; }
ln -sf ../mods-available/always
ln -sf ../mods-available/attr_filter
ln -sf ../mods-available/chap
ln -sf ../mods-available/detail
ln -sf ../mods-available/digest
ln -sf ../mods-available/eap
ln -sf ../mods-available/exec
ln -sf ../mods-available/expiration
ln -sf ../mods-available/expr
ln -sf ../mods-available/files
ln -sf ../mods-available/logintime
ln -sf ../mods-available/mschap
ln -sf ../mods-available/pap
ln -sf ../mods-available/preprocess
ln -sf ../mods-available/radutmp
ln -sf ../mods-available/realm
ln -sf ../mods-available/sql
ln -sf ../mods-available/sradutmp
ln -sf ../mods-available/unix
cd || { echo -e "${RED}Gagal kembali ke direktori home. Keluar...${RESET}"; exit 1; }
show_banner

sleep 1 

echo -e "$(get_random_color)Membuat Link sites-enabled...${RESET}"
cd /etc/freeradius3/sites-enabled || { echo -e "${RED}Gagal masuk ke direktori sites-enabled. Keluar...${RESET}"; exit 1; }
ln -sf ../sites-available/default
ln -sf ../sites-available/inner-tunnel
cd || { echo -e "${RED}Gagal kembali ke direktori home. Keluar...${RESET}"; exit 1; }
show_banner

sleep 1

echo -e "$(get_random_color)Mendownload RadMonv2...${RESET}"

if [ -d "/usr/share/RadMonv2" ]; then
    echo -e "${YELLOW}Menghapus RadMonv2 yang sudah ada...${RESET}"
    rm -rf /usr/share/RadMonv2
fi

if ! git clone --depth 1 https://github.com/maizil41/RadMonv2.git /usr/share/RadMonv2 >/dev/null 2>&1; then
    echo -e "${RED}Gagal mendownload RadMonv2. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Mendownload Pear...${RESET}"
cd /root/ || { echo -e "${RED}Gagal masuk ke direktori root. Keluar...${RESET}"; exit 1; }
if ! curl -L https://pear.php.net/go-pear.phar -O go-pear.phar; then
    echo -e "${GREEN}Success mendownload Pear.${RESET}"
fi
show_banner

sleep 1

ln -sf /usr/bin/php-cli /usr/bin/php
if ! php-cli go-pear.phar; then
    echo -e "${RED}Gagal mensetup Pear. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1 

echo -e "$(get_random_color)Menginstall Pear DB...${RESET}"

if pear list | grep -q "DB"; then
    echo -e "${YELLOW}PEAR DB sudah terinstall. Melewati instalasi...${RESET}"
else
    if ! pear install DB >/dev/null 2>&1; then
        echo -e "${RED}Gagal menginstall Pear DB. Keluar...${RESET}"
        exit 1
    fi
fi
show_banner

sleep 1

echo -e "$(get_random_color)Menginstall Database RadMon...${RESET}"
cd /www/RadMonv2 || { echo -e "${RED}Gagal masuk ke direktori RadMonv2. Keluar...${RESET}"; exit 1; }
if ! mysql -u root -pradmon radmon < radmonv2.sql; then
    echo -e "${RED}Gagal menginstall database RadMon. Keluar...${RESET}"
    exit 1
fi
show_banner

sleep 1

echo -e "$(get_random_color)Membuat Cronjob...${RESET}"
(crontab -l; echo "* * * * * /usr/bin/radmon-kuota >/dev/null 2>&1") | crontab -
(crontab -l; echo "0 0 * * * rm -f /www/RadMonv2/voucher/tmp/*.png >/dev/null 2>&1") | crontab -
show_banner

sleep 1

echo -e "$(get_random_color)Konfigurasi Interface...${RESET}"
uci set network.@device[0].ports='eth0.1'

uci set network.radius=device
uci set network.radius.name='br-radius'
uci set network.radius.type='bridge'
uci set network.radius.ipv6='0'
uci add_list network.radius.ports='eth0'

uci set network.hotspot=interface
uci set network.hotspot.proto='static'
uci set network.hotspot.device='br-radius'
uci set network.hotspot.ipaddr='10.10.30.1'
uci set network.hotspot.netmask='255.255.255.0'

uci set network.chilli=interface
uci set network.chilli.proto='none'
uci set network.chilli.device='tun0'

uci commit network

show_banner

sleep 1

echo -e "$(get_random_color)Konfigurasi Firewall...${RESET}"
uci set firewall.coova_chilli=zone
uci set firewall.coova_chilli.name='coova_chilli'
uci set firewall.coova_chilli.input='ACCEPT'
uci set firewall.coova_chilli.output='ACCEPT'
uci set firewall.coova_chilli.forward='REJECT'
uci add_list firewall.coova_chilli.network='chilli'

uci add firewall forwarding
uci set firewall.@forwarding[-1].src='coova_chilli'
uci set firewall.@forwarding[-1].dest='wan'

uci add_list firewall.@zone[0].network='hotspot'

uci commit firewall

show_banner

sleep 1

echo -e "${GREEN}Instalasi selesai!, Tekan Enter...${RESET}"
read -r

echo -e "${YELLOW}Merestart Perangkat...${RESET}"
reboot