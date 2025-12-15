package frontEnd

import (
	"log"
	"myDocker/pkg"
	"os"
	"strings"
)

type ByteSlic []byte

func (v ByteSlic) convertToString() string { return string(v) }

func ReadFile() (bool, error) {
	currentIp := pkg.GetLocalIP()
	defaultEnvDir := "D:\\Gabriel\\MVPs\\1\\frontend\\.env"

	fileData, err := os.ReadFile(defaultEnvDir)

	log.Println("File Data: ", fileData)

	if len(fileData) == 0 {
		return false, nil

	}

	if err != nil {
		log.Printf("Erro ao ler o arquivo: %s", defaultEnvDir)
		return false, err

	}

	strFileData := ByteSlic(fileData).convertToString()

	if strings.Contains(strFileData, currentIp.To16().String()) {
		log.Printf("A .env atual: %s já tem o IP atual: %s, não vai trocar", strFileData, currentIp)
		return true, nil

	} else {
		log.Printf("A .env atual: %s não tem o IP atual: %s, vai trocar", strFileData, currentIp)
		return false, nil
	}
}
